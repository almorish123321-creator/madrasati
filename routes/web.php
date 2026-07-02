<?php

use App\Http\Controllers\Classrooms\ClassroomController;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('selection');

Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    Route::get('/login/{type}', 'LoginController@loginForm')->middleware('guest')->name('login.show');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::get('/logout/{type}', 'LoginController@logout')->name('logout');
});

//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {

        //==============================dashboard============================
        Route::get('/dashboard', 'App\Http\Controllers\DashboardAnalytics\DashboardAnalyticsController@adminDashboard')->name('dashboard');

        //==============================Grades============================
        Route::group(['namespace' => 'App\Http\Controllers\Grades'], function () {
            Route::resource('Grades', 'GradeController');
        });

        //==============================Classrooms============================
        Route::group(['namespace' => 'App\Http\Controllers\Classrooms'], function () {
            Route::resource('Classrooms', 'ClassroomController');
            Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');
            Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');
        });

        //==============================Sections============================
        Route::group(['namespace' => 'App\Http\Controllers\Sections'], function () {
            Route::resource('Sections', 'SectionController');
            Route::get('/classes/{id}', 'SectionController@getclasses');
        });

        //==============================Parents============================
        Route::view('add_parent', 'livewire.show_Form')->name('add_parent');

        //==============================Teachers============================
        Route::group(['namespace' => 'App\Http\Controllers\Teachers'], function () {
            Route::resource('Teachers', 'TeacherController');
        });

        //==============================Students============================
        Route::group(['namespace' => 'App\Http\Controllers\Students'], function () {
            Route::resource('Students', 'StudentController');
            Route::get('indirect_admin', 'OnlineClasseController@indirectCreate')->name('indirect.create');
            Route::post('indirect_admin', 'OnlineClasseController@storeIndirect')->name('indirect.store');
            Route::resource('online_classes', 'OnlineClasseController');
            Route::resource('Promotion', 'PromotionController');
            Route::resource('Graduated', 'GraduatedController');
            Route::resource('Fees', 'FeesController');
            Route::resource('Fees_Invoices', 'FeesInvoicesController');
            Route::resource('receipt_students', 'ReceiptStudentsController');
            Route::resource('ProcessingFee', 'ProcessingFeeController');
            Route::resource('Payment_students', 'PaymentController');
            Route::resource('Attendance', 'AttendanceController');
            Route::get('download_file/{filename}', 'LibraryController@downloadAttachment')->name('downloadAttachment');
            Route::resource('library', 'LibraryController');
            Route::post('Upload_attachment', 'StudentController@Upload_attachment')->name('Upload_attachment');
            Route::get('Download_attachment/{studentsname}/{filename}', 'StudentController@Download_attachment')->name('Download_attachment');
            Route::post('Delete_attachment', 'StudentController@Delete_attachment')->name('Delete_attachment');
        });

        //==============================Subjects============================
        Route::group(['namespace' => 'App\Http\Controllers\Subjects'], function () {
            Route::resource('subjects', 'SubjectController');
        });

        //==============================Quizzes============================
        Route::group(['namespace' => 'App\Http\Controllers\Quizzes'], function () {
            Route::resource('Quizzes', 'QuizzController');
        });

        //==============================questions============================
        Route::group(['namespace' => 'App\Http\Controllers\Questions'], function () {
            Route::resource('Questions', 'QuestionController');
        });

        //==============================Setting============================
        Route::resource('settings', 'App\Http\Controllers\SettingController');

        //==============================Import & Export (NEW - Repository Pattern)============================
        Route::group(['namespace' => 'App\Http\Controllers\ExportImport'], function () {
            // Student Import
            Route::get('students/import', 'ExportImportController@showStudentImportForm')->name('students.import_form');
            Route::post('students/import', 'ExportImportController@importStudents')->name('students.import');
            Route::get('students/import/template', 'ExportImportController@downloadStudentTemplate')->name('students.download_template');
            // Teacher Import
            Route::get('teachers/import', 'ExportImportController@showTeacherImportForm')->name('teachers.import_form');
            Route::post('teachers/import', 'ExportImportController@importTeachers')->name('teachers.import');
            Route::get('teachers/import/template', 'ExportImportController@downloadTeacherTemplate')->name('teachers.download_template');
            // Grades Import
            Route::get('grades/import', 'ExportImportController@showGradesImportForm')->name('grades.import_form');
            Route::post('grades/import', 'ExportImportController@importGrades')->name('grades.import');
            Route::get('grades/import/template', 'ExportImportController@downloadGradesTemplate')->name('grades.download_template');
            // Attendance Import
            Route::get('attendance/import', 'ExportImportController@showAttendanceImportForm')->name('attendance.import_form');
            Route::post('attendance/import', 'ExportImportController@importAttendance')->name('attendance.import');
            Route::get('attendance/import/template', 'ExportImportController@downloadAttendanceTemplate')->name('attendance.download_template');
            // Import Errors
            Route::get('import/errors', 'ExportImportController@showImportErrors')->name('import.errors');
            Route::get('import/errors/download', 'ExportImportController@downloadErrors')->name('import.download_errors');
            // PDF Exports
            Route::get('export/class-pdf/{classroomId}', 'ExportImportController@exportClassListPDF')->name('students.export_class_pdf');
            Route::get('export/degrees-pdf/{classroomId}', 'ExportImportController@exportDegreesPDF')->name('export.degrees_pdf');
            Route::get('export/fee-invoice-pdf/{invoiceId}', 'ExportImportController@exportFeeInvoicePDF')->name('export.fee_invoice_pdf');
            Route::get('export/receipt-pdf/{receiptId}', 'ExportImportController@exportReceiptPDF')->name('export.receipt_pdf');
            Route::get('export/final-results-pdf/{classroomId}', 'ExportImportController@exportFinalResultsPDF')->name('export.final_results_pdf');
            // Attendance Export Form/PDF
            Route::get('export/attendance-form/{classroomId}', 'ExportImportController@showAttendanceExportForm')->name('students.export_attendance_form');
            Route::post('export/attendance/{classroomId}', 'ExportImportController@exportAttendanceExcel')->name('students.export_attendance');
            // Excel Exports
            Route::get('export/students-excel', 'ExportImportController@exportStudentsExcel')->name('export.students_excel');
            Route::get('export/teachers-excel', 'ExportImportController@exportTeachersExcel')->name('export.teachers_excel');
            Route::get('export/degrees-excel/{classroomId}', 'ExportImportController@exportDegreesExcel')->name('export.degrees_excel');
            Route::get('export/fees-excel', 'ExportImportController@exportFeesExcel')->name('export.fees_excel');
        });

        //==============================Notifications==============================
        Route::group(['namespace' => 'App\Http\Controllers\Notifications'], function () {
            Route::get('notifications', 'NotificationController@index')->name('notifications.index');
            Route::get('notifications/read/{id}', 'NotificationController@markAsRead')->name('notifications.markRead');
            Route::post('notifications/read-all', 'NotificationController@markAllAsRead')->name('notifications.markAllRead');
        });

        //==============================Messages==============================
        Route::group(['namespace' => 'App\Http\Controllers\Messages'], function () {
            Route::get('messages/inbox', 'MessageController@inbox')->name('messages.inbox');
            Route::get('messages/sent', 'MessageController@sent')->name('messages.sent');
            Route::get('messages/create', 'MessageController@create')->name('messages.create');
            Route::post('messages', 'MessageController@store')->name('messages.store');
            Route::get('messages/{id}', 'MessageController@show')->name('messages.show');
            Route::post('messages/delete', 'MessageController@destroy')->name('messages.destroy');
        });

        //==============================Homework==============================
        Route::group(['namespace' => 'App\Http\Controllers\Homework'], function () {
            Route::resource('homeworks', 'HomeworkController');
            Route::get('homeworks/{id}/submissions', 'HomeworkController@submissions')->name('homeworks.submissions');
        });

        //==============================Behavioral==============================
        Route::group(['namespace' => 'App\Http\Controllers\Behavioral'], function () {
            Route::get('behavioral', 'BehavioralController@index')->name('behavioral.index');
            Route::get('behavioral/create/{studentId?}', 'BehavioralController@create')->name('behavioral.create');
            Route::post('behavioral', 'BehavioralController@store')->name('behavioral.store');
            Route::get('behavioral/{id}', 'BehavioralController@show')->name('behavioral.show');
            Route::post('behavioral/delete', 'BehavioralController@destroy')->name('behavioral.destroy');
        });

        //==============================Transportation==============================
        Route::group(['namespace' => 'App\Http\Controllers\Transportation'], function () {
            Route::resource('buses', 'BusController');
            Route::get('buses/{id}/show', 'BusController@show')->name('buses.show');
            Route::post('buses/assign', 'BusController@assignStudent')->name('buses.assign');
            Route::post('buses/remove', 'BusController@removeStudent')->name('buses.remove');
        });

        //==============================Activity Log==============================
        Route::group(['namespace' => 'App\Http\Controllers\ActivityLog'], function () {
            Route::get('activity-log', 'ActivityLogController@index')->name('activity-log.index');
            Route::post('activity-log/clear', 'ActivityLogController@clear')->name('activity-log.clear');
        });

        //==============================Backup==============================
        Route::group(['namespace' => 'App\Http\Controllers\Backup'], function () {
            Route::get('backup', 'BackupController@index')->name('backup.index');
            Route::post('backup/create', 'BackupController@create')->name('backup.create');
            Route::get('backup/download/{fileName}', 'BackupController@download')->name('backup.download');
            Route::post('backup/delete/{fileName}', 'BackupController@delete')->name('backup.delete');
        });
    }
);