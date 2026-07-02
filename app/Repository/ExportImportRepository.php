<?php

namespace App\Repository;

use App\Imports\StudentsImport;
use App\Imports\TeachersImport;
use App\Imports\GradesImport;
use App\Imports\AttendanceImport;
use App\Exports\StudentsListExport;
use App\Exports\TeachersListExport;
use App\Exports\AttendanceExport;
use App\Exports\DegreesExport;
use App\Exports\FeesExport;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Degree;
use App\Models\Fee_invoice;
use App\Models\ReceiptStudent;
use App\Models\Subject;
use App\Models\Setting;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportImportRepository implements ExportImportRepositoryInterface
{
    public function showStudentImportForm()
    {
        $Grades = \App\Models\Grade::all();
        return view('pages.Students.import', compact('Grades'));
    }

    public function importStudents($request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new StudentsImport();
        $import->import($request->file('file'));

        $errors = $import->getErrors();

        if ($errors->isNotEmpty()) {
            session()->flash('import_errors', $errors);
            return redirect()->route('students.import_errors');
        }

        toastr()->success(trans('messages.Import_success'));
        return redirect()->route('Students.index');
    }

    public function downloadStudentTemplate()
    {
        return Excel::download(new \App\Exports\StudentImportTemplateExport, 'student_import_template.xlsx');
    }

    public function showTeacherImportForm()
    {
        return view('pages.Teachers.import');
    }

    public function importTeachers($request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new TeachersImport();
        $import->import($request->file('file'));

        $errors = $import->getErrors();

        if ($errors->isNotEmpty()) {
            session()->flash('import_errors', $errors);
            return redirect()->route('teachers.import_errors');
        }

        toastr()->success(trans('messages.Import_success'));
        return redirect()->route('Teachers.index');
    }

    public function downloadTeacherTemplate()
    {
        return Excel::download(new \App\Exports\TeacherImportTemplateExport, 'teacher_import_template.xlsx');
    }

    public function showGradesImportForm()
    {
        return view('pages.Exports.grades_import_form');
    }

    public function importGrades($request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new GradesImport();
        $import->import($request->file('file'));

        $errors = $import->getErrors();

        if ($errors->isNotEmpty()) {
            session()->flash('import_errors', $errors);
            return redirect()->route('grades.import_errors');
        }

        toastr()->success(trans('messages.Import_success'));
        return redirect()->route('Quizzes.index');
    }

    public function downloadGradesTemplate()
    {
        return Excel::download(new \App\Exports\GradesImportTemplateExport, 'grades_import_template.xlsx');
    }

    public function showAttendanceImportForm()
    {
        return view('pages.Attendance.import');
    }

    public function importAttendance($request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new AttendanceImport();
        $import->import($request->file('file'));

        $errors = $import->getErrors();

        if ($errors->isNotEmpty()) {
            session()->flash('import_errors', $errors);
            return redirect()->route('attendance.import_errors');
        }

        toastr()->success(trans('messages.Import_success'));
        return redirect()->route('Attendance.index');
    }

    public function downloadAttendanceTemplate()
    {
        return Excel::download(new \App\Exports\AttendanceImportTemplateExport, 'attendance_import_template.xlsx');
    }

    public function showImportErrors()
    {
        $errors = session('import_errors', collect());
        return view('pages.Exports.import_errors', compact('errors'));
    }

    public function exportClassListPDF($classroomId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $students = Student::where('Classroom_id', $classroomId)
            ->with(['gender', 'section', 'grade'])
            ->orderBy('section_id')
            ->orderBy('name')
            ->get();
        $setting = Setting::first();

        $pdf = Pdf::loadView('pages.Exports.classlist_pdf', compact('students', 'classroom', 'setting'));
        return $pdf->stream('classlist_' . $classroom->Name_Class . '.pdf');
    }

    public function exportStudentsExcel()
    {
        return Excel::download(new StudentsListExport, 'students_list.xlsx');
    }

    public function exportTeachersExcel()
    {
        return Excel::download(new TeachersListExport, 'teachers_list.xlsx');
    }

    public function exportAttendanceExcel($classroomId, $month, $year)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $students = Student::where('Classroom_id', $classroomId)
            ->with(['attendance' => function($q) use ($month, $year) {
                $q->whereMonth('attendence_date', $month)->whereYear('attendence_date', $year);
            }])
            ->orderBy('name')->get();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $pdf = Pdf::loadView('pages.Exports.attendance_excel', compact('students', 'classroom', 'month', 'year', 'daysInMonth'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('attendance_' . $classroom->Name_Class . '.pdf');
    }

    public function showAttendanceExportForm($classroomId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        return view('pages.Exports.attendance_form', compact('classroom'));
    }

    public function exportDegreesPDF($classroomId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $students = Student::where('Classroom_id', $classroomId)
            ->with(['degrees', 'section'])
            ->orderBy('section_id')
            ->orderBy('name')
            ->get();
        $subjects = Subject::whereHas('classrooms', function($q) use ($classroomId) {
            $q->where('classroom_id', $classroomId);
        })->orWhereHas('sections', function($q) use ($classroomId) {
            $q->whereIn('section_id', Section::where('Class_id', $classroomId)->pluck('id'));
        })->get();

        $allSubjects = Subject::all();
        $setting = Setting::first();

        foreach ($students as $student) {
            $total = 0;
            $count = 0;
            foreach ($student->degrees as $degree) {
                $total += $degree->degree;
                $count++;
            }
            $student->total_score = $total;
            $student->avg_score = $count > 0 ? round($total / $count, 2) : 0;
            if ($student->avg_score >= 90) {
                $student->grade_label = 'ممتاز';
            } elseif ($student->avg_score >= 80) {
                $student->grade_label = 'جيد جدا';
            } elseif ($student->avg_score >= 70) {
                $student->grade_label = 'جيد';
            } elseif ($student->avg_score >= 60) {
                $student->grade_label = 'مقبول';
            } else {
                $student->grade_label = 'راسب';
            }
        }

        $pdf = Pdf::loadView('pages.Exports.degrees_pdf', compact('students', 'classroom', 'allSubjects', 'setting'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('degrees_' . $classroom->Name_Class . '.pdf');
    }

    public function exportDegreesExcel($classroomId)
    {
        return Excel::download(new DegreesExport($classroomId), 'degrees.xlsx');
    }

    public function exportFeeInvoicePDF($invoiceId)
    {
        $invoice = Fee_invoice::findOrFail($invoiceId);
        $student = Student::findOrFail($invoice->student_id);
        $fee = \App\Models\Fee::findOrFail($invoice->fee_id);
        $setting = Setting::first();

        $pdf = Pdf::loadView('pages.Exports.fee_invoice_pdf', compact('invoice', 'student', 'fee', 'setting'));
        return $pdf->stream('fee_invoice_' . $invoice->id . '.pdf');
    }

    public function exportReceiptPDF($receiptId)
    {
        $receipt = ReceiptStudent::findOrFail($receiptId);
        $student = Student::findOrFail($receipt->student_id);
        $setting = Setting::first();

        $pdf = Pdf::loadView('pages.Exports.receipt_pdf', compact('receipt', 'student', 'setting'));
        return $pdf->stream('receipt_' . $receipt->id . '.pdf');
    }

    public function exportFinalResultsPDF($classroomId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $students = Student::where('Classroom_id', $classroomId)
            ->with(['degrees', 'section', 'grade'])
            ->orderBy('section_id')
            ->orderBy('name')
            ->get();
        $allSubjects = Subject::all();
        $setting = Setting::first();

        foreach ($students as $student) {
            $total = 0; $count = 0;
            foreach ($student->degrees as $degree) { $total += $degree->degree; $count++; }
            $student->total_score = $total;
            $student->avg_score = $count > 0 ? round($total / $count, 2) : 0;
            $student->grade_label = $student->avg_score >= 90 ? 'ممتاز' : ($student->avg_score >= 80 ? 'جيد جدا' : ($student->avg_score >= 70 ? 'جيد' : ($student->avg_score >= 60 ? 'مقبول' : 'راسب')));
        }

        $pdf = Pdf::loadView('pages.Exports.final_results_pdf', compact('students', 'classroom', 'allSubjects', 'setting'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('final_results_' . $classroom->Name_Class . '.pdf');
    }

    public function exportFeesExcel()
    {
        return Excel::download(new FeesExport, 'fees_invoices.xlsx');
    }
}