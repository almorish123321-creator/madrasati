<?php

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ],
    function () {

        Route::get('/teacher/dashboard', 'App\Http\Controllers\DashboardAnalytics\DashboardAnalyticsController@teacherDashboard')->name('dashboard.Teachers');

        Route::group(['namespace' => 'App\Http\Controllers\Teachers\dashboard'], function () {
            Route::get('student', 'StudentController@index')->name('student.index');
            Route::get('sections', 'StudentController@sections')->name('sections');
            Route::post('attendance', 'StudentController@attendance')->name('attendance');
            Route::post('edit_attendance', 'StudentController@editAttendance')->name('attendance.edit');
            Route::get('attendance_report', 'StudentController@attendanceReport')->name('attendance.report');
            Route::post('attendance_report', 'StudentController@attendanceSearch')->name('attendance.search');
            Route::resource('quizzes', 'QuizzController');
            Route::resource('questions', 'QuestionController');
            Route::resource('online_zoom_classes', 'OnlineZoomClassesController');
            Route::get('/indirect', 'OnlineZoomClassesController@indirectCreate')->name('indirect.teacher.create');
            Route::post('/indirect', 'OnlineZoomClassesController@storeIndirect')->name('indirect.teacher.store');
            Route::get('profile', 'ProfileController@index')->name('profile.show');
            Route::post('profile/{id}', 'ProfileController@update')->name('profile.update');
            Route::get('student_quizze/{id}', 'QuizzController@student_quizze')->name('student.quizze');
            Route::post('repeat_quizze', 'QuizzController@repeat_quizze')->name('repeat.quizze');
        });

        // Teacher Homework
        Route::group(['namespace' => 'App\Http\Controllers\Homework'], function () {
            Route::resource('teacher/homeworks', 'HomeworkController');
            Route::get('teacher/homeworks/{id}/submissions', 'HomeworkController@submissions')->name('teacher.homeworks.submissions');
        });

        // Teacher Behavioral
        Route::group(['namespace' => 'App\Http\Controllers\Behavioral'], function () {
            Route::get('teacher/behavioral', 'BehavioralController@index')->name('teacher.behavioral.index');
            Route::get('teacher/behavioral/create', 'BehavioralController@create')->name('teacher.behavioral.create');
            Route::post('teacher/behavioral', 'BehavioralController@store')->name('teacher.behavioral.store');
            Route::post('teacher/behavioral/delete', 'BehavioralController@destroy')->name('teacher.behavioral.destroy');
        });

        // Teacher Notifications
        Route::get('teacher/notifications', 'App\Http\Controllers\Notifications\NotificationController@index')->name('teacher.notifications.index');
        Route::get('teacher/notifications/read/{id}', 'App\Http\Controllers\Notifications\NotificationController@markAsRead')->name('teacher.notifications.markRead');
    }
);