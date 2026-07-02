<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:student']
    ],
    function () {

        Route::get('/student/dashboard', 'App\Http\Controllers\DashboardAnalytics\DashboardAnalyticsController@studentDashboard')->name('dashboard.Students');

        Route::group(['namespace' => 'App\Http\Controllers\Students\dashboard'], function () {
            Route::resource('student_exams', 'ExamsController');
            Route::resource('profile-student', 'ProfileController');
        });

        // Student Homework
        Route::get('student/homeworks', 'App\Http\Controllers\Homework\HomeworkController@studentHomeworks')->name('student.homeworks');
        Route::post('student/homeworks/submit', 'App\Http\Controllers\Homework\HomeworkController@submitHomework')->name('student.homeworks.submit');

        // Student Behavioral
        Route::get('student/behavioral', 'App\Http\Controllers\Behavioral\BehavioralController@studentRecords')->name('student.behavioral');

        // Student Notifications
        Route::get('student/notifications', 'App\Http\Controllers\Notifications\NotificationController@index')->name('student.notifications.index');
        Route::get('student/notifications/read/{id}', 'App\Http\Controllers\Notifications\NotificationController@markAsRead')->name('student.notifications.markRead');

        // Student Messages
        Route::get('student/messages/inbox', 'App\Http\Controllers\Messages\MessageController@inbox')->name('student.messages.inbox');
        Route::get('student/messages/sent', 'App\Http\Controllers\Messages\MessageController@sent')->name('student.messages.sent');
        Route::get('student/messages/create', 'App\Http\Controllers\Messages\MessageController@create')->name('student.messages.create');
        Route::post('student/messages', 'App\Http\Controllers\Messages\MessageController@store')->name('student.messages.store');
        Route::get('student/messages/{id}', 'App\Http\Controllers\Messages\MessageController@show')->name('student.messages.show');
        Route::post('student/messages/delete', 'App\Http\Controllers\Messages\MessageController@destroy')->name('student.messages.destroy');
    }
);