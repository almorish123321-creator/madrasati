<?php

namespace App\Http\Controllers\ExportImport;

use App\Http\Controllers\Controller;
use App\Repository\ExportImportRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ErrorExport;

class ExportImportController extends Controller
{
    protected $ExportImport;

    public function __construct(ExportImportRepositoryInterface $ExportImport)
    {
        $this->ExportImport = $ExportImport;
    }

    // Student Import
    public function showStudentImportForm()
    {
        return $this->ExportImport->showStudentImportForm();
    }

    public function importStudents(Request $request)
    {
        return $this->ExportImport->importStudents($request);
    }

    public function downloadStudentTemplate()
    {
        return $this->ExportImport->downloadStudentTemplate();
    }

    // Teacher Import
    public function showTeacherImportForm()
    {
        return $this->ExportImport->showTeacherImportForm();
    }

    public function importTeachers(Request $request)
    {
        return $this->ExportImport->importTeachers($request);
    }

    public function downloadTeacherTemplate()
    {
        return $this->ExportImport->downloadTeacherTemplate();
    }

    // Grades Import
    public function showGradesImportForm()
    {
        return $this->ExportImport->showGradesImportForm();
    }

    public function importGrades(Request $request)
    {
        return $this->ExportImport->importGrades($request);
    }

    public function downloadGradesTemplate()
    {
        return $this->ExportImport->downloadGradesTemplate();
    }

    // Attendance Import
    public function showAttendanceImportForm()
    {
        return $this->ExportImport->showAttendanceImportForm();
    }

    public function importAttendance(Request $request)
    {
        return $this->ExportImport->importAttendance($request);
    }

    public function downloadAttendanceTemplate()
    {
        return $this->ExportImport->downloadAttendanceTemplate();
    }

    // Import Errors
    public function showImportErrors()
    {
        return $this->ExportImport->showImportErrors();
    }

    public function downloadErrors()
    {
        $errors = session('import_errors', collect());
        return Excel::download(new ErrorExport($errors), 'import_errors.xlsx');
    }

    // PDF Exports
    public function exportClassListPDF($classroomId)
    {
        return $this->ExportImport->exportClassListPDF($classroomId);
    }

    public function exportDegreesPDF($classroomId)
    {
        return $this->ExportImport->exportDegreesPDF($classroomId);
    }

    public function exportFeeInvoicePDF($invoiceId)
    {
        return $this->ExportImport->exportFeeInvoicePDF($invoiceId);
    }

    public function exportReceiptPDF($receiptId)
    {
        return $this->ExportImport->exportReceiptPDF($receiptId);
    }

    public function exportFinalResultsPDF($classroomId)
    {
        return $this->ExportImport->exportFinalResultsPDF($classroomId);
    }

    // Excel Exports
    public function exportStudentsExcel()
    {
        return $this->ExportImport->exportStudentsExcel();
    }

    public function exportTeachersExcel()
    {
        return $this->ExportImport->exportTeachersExcel();
    }

    public function exportDegreesExcel($classroomId)
    {
        return $this->ExportImport->exportDegreesExcel($classroomId);
    }

    public function exportFeesExcel()
    {
        return $this->ExportImport->exportFeesExcel();
    }

    // Attendance Export
    public function showAttendanceExportForm($classroomId)
    {
        return $this->ExportImport->showAttendanceExportForm($classroomId);
    }

    public function exportAttendanceExcel(Request $request, $classroomId)
    {
        return $this->ExportImport->exportAttendanceExcel($classroomId, $request->month, $request->year);
    }
}