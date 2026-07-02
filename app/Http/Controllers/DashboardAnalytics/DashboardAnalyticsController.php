<?php

namespace App\Http\Controllers\DashboardAnalytics;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Attendance;
use App\Models\Fee_invoice;
use App\Models\Degree;
use App\Models\Grade;
use App\Models\My_Parent;

class DashboardAnalyticsController extends Controller
{
    public function adminDashboard()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalSections = Section::count();
        $totalGrades = Grade::count();

        // Monthly attendance rate
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $totalAttendance = Attendance::whereMonth('attendence_date', $currentMonth)
            ->whereYear('attendence_date', $currentYear)->count();
        $presentCount = Attendance::whereMonth('attendence_date', $currentMonth)
            ->whereYear('attendence_date', $currentYear)
            ->where('attendence_status', 0)->count();
        $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;

        // Fee revenue this month
        $monthlyRevenue = Fee_invoice::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->where('invoice_status', 1)
            ->sum('amount');

        // Top 10 students
        $topStudents = Student::with('degrees')
            ->get()
            ->map(function ($student) {
                $degrees = $student->degrees;
                $total = $degrees->sum('degree');
                $count = $degrees->count();
                $student->avg = $count > 0 ? round($total / $count, 2) : 0;
                return $student;
            })
            ->sortByDesc('avg')
            ->take(10);

        // Students per grade
        $studentsPerGrade = Grade::withCount('students')->get();

        // Monthly attendance trend (last 6 months)
        $attendanceTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $total = Attendance::whereMonth('attendence_date', $month->month)
                ->whereYear('attendence_date', $month->year)->count();
            $present = Attendance::whereMonth('attendence_date', $month->month)
                ->whereYear('attendence_date', $month->year)
                ->where('attendence_status', 0)->count();
            $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;
            $attendanceTrend[] = [
                'month' => $month->format('M'),
                'rate' => $rate,
            ];
        }

        return view('dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalSections', 'totalGrades',
            'attendanceRate', 'monthlyRevenue', 'topStudents', 'studentsPerGrade',
            'attendanceTrend'
        ));
    }

    public function teacherDashboard()
    {
        $teacherId = auth()->user()->id;
        $sections = \App\Models\Teacher::findOrFail($teacherId)->Sections;
        $sectionIds = $sections->pluck('id');

        $totalStudents = Student::whereIn('section_id', $sectionIds)->count();
        $totalSections = $sectionIds->count();

        // Attendance rate for teacher's sections
        $totalAttendance = Attendance::whereIn('section_id', $sectionIds)
            ->whereMonth('attendence_date', now()->month)
            ->whereYear('attendence_date', now()->year)->count();
        $presentCount = Attendance::whereIn('section_id', $sectionIds)
            ->whereMonth('attendence_date', now()->month)
            ->whereYear('attendence_date', now()->year)
            ->where('attendence_status', 0)->count();
        $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;

        // Average degree for teacher's quizzes
        $teacherQuizIds = \App\Models\Quizze::where('teacher_id', $teacherId)->pluck('id');
        $avgDegree = Degree::whereIn('quizze_id', $teacherQuizIds)->avg('degree') ?? 0;
        $avgDegree = round($avgDegree, 1);

        // Sections student count
        $sectionsData = $sections->map(function ($section) {
            $section->student_count = Student::where('section_id', $section->id)->count();
            return $section;
        });

        return view('pages.Teachers.dashboard.dashboard', [
            'count_sections' => $totalSections,
            'count_students' => $totalStudents,
            'attendanceRate' => $attendanceRate,
            'avgDegree' => $avgDegree,
            'sectionsData' => $sectionsData,
            'sections' => $sections,
        ]);
    }

    public function studentDashboard()
    {
        $student = Student::where('id', auth()->user()->id)->first()
            ?? Student::where('email', auth()->user()->email)->first();

        $degrees = [];
        $attendanceRate = 0;

        if ($student) {
            $degrees = Degree::where('student_id', $student->id)
                ->with('quizze.subject')
                ->get();

            $total = Attendance::where('student_id', $student->id)->count();
            $present = Attendance::where('student_id', $student->id)->where('attendence_status', 0)->count();
            $attendanceRate = $total > 0 ? round(($present / $total) * 100, 1) : 0;
        }

        return view('pages.Students.dashboard', compact('degrees', 'attendanceRate', 'student'));
    }

    public function parentDashboard()
    {
        $sons = Student::where('parent_id', auth()->user()->id)->with(['degrees', 'attendance', 'grade', 'section'])->get();

        $childrenStats = $sons->map(function ($student) {
            $total = $student->attendance->count();
            $present = $student->attendance->where('attendence_status', 0)->count();
            $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;
            $avgDegree = $student->degrees->avg('degree') ? round($student->degrees->avg('degree'), 1) : 0;

            return [
                'name' => $student->getTranslation('name', 'ar'),
                'grade' => $student->grade ? $student->grade->getTranslation('Name_Grade', 'ar') : '',
                'section' => $student->section ? $student->section->getTranslation('Name_Section', 'ar') : '',
                'attendance_rate' => $rate,
                'avg_degree' => $avgDegree,
            ];
        });

        return view('pages.parents.dashboard', ['sons' => $sons, 'childrenStats' => $childrenStats]);
    }
}