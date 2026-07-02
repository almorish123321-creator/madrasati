<?php

namespace App\Repository;

interface ExportImportRepositoryInterface
{
    public function showStudentImportForm();
    public function importStudents($request);
    public function downloadStudentTemplate();
    public function showTeacherImportForm();
    public function importTeachers($request);
    public function downloadTeacherTemplate();
    public function showGradesImportForm();
    public function importGrades($request);
    public function downloadGradesTemplate();
    public function showAttendanceImportForm();
    public function importAttendance($request);
    public function downloadAttendanceTemplate();
    public function showImportErrors();
    public function exportClassListPDF($classroomId);
    public function exportStudentsExcel();
    public function exportTeachersExcel();
    public function exportAttendanceExcel($classroomId, $month, $year);
    public function exportDegreesPDF($classroomId);
    public function exportDegreesExcel($classroomId);
    public function exportFeeInvoicePDF($invoiceId);
    public function exportReceiptPDF($receiptId);
    public function exportFinalResultsPDF($classroomId);
    public function exportFeesExcel();
    public function showAttendanceExportForm($classroomId);
}