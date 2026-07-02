<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:parent']
    ],
    function () {

        Route::get('/parent/dashboard', 'App\Http\Controllers\DashboardAnalytics\DashboardAnalyticsController@parentDashboard')->name('dashboard.parents');

        Route::group(['namespace' => 'App\Http\Controllers\Parents\dashboard'], function () {
            Route::get('children', 'ChildrenController@index')->name('sons.index');
            Route::get('results/{id}', 'ChildrenController@results')->name('sons.results');
            Route::get('attendances', 'ChildrenController@attendances')->name('sons.attendances');
            Route::post('attendances', 'ChildrenController@attendanceSearch')->name('sons.attendance.search');
            Route::get('fees', 'ChildrenController@fees')->name('sons.fees');
            Route::get('receipt/{id}', 'ChildrenController@receiptStudent')->name('sons.receipt');
            Route::get('profile/parent', 'ChildrenController@profile')->name('profile.show.parent');
            Route::post('profile/parent/{id}', 'ChildrenController@update')->name('profile.update.parent');
        });

        // Parent Behavioral
        Route::get('parent/behavioral/{id}', 'App\Http\Controllers\Behavioral\BehavioralController@show')->name('parent.behavioral.show');

        // Parent Notifications
        Route::get('parent/notifications', 'App\Http\Controllers\Notifications\NotificationController@index')->name('parent.notifications.index');
        Route::get('parent/notifications/read/{id}', 'App\Http\Controllers\Notifications\NotificationController@markAsRead')->name('parent.notifications.markRead');

        // Parent Messages
        Route::get('parent/messages/inbox', 'App\Http\Controllers\Messages\MessageController@inbox')->name('parent.messages.inbox');
        Route::get('parent/messages/sent', 'App\Http\Controllers\Messages\MessageController@sent')->name('parent.messages.sent');
        Route::get('parent/messages/create', 'App\Http\Controllers\Messages\MessageController@create')->name('parent.messages.create');
        Route::post('parent/messages', 'App\Http\Controllers\Messages\MessageController@store')->name('parent.messages.store');
        Route::get('parent/messages/{id}', 'App\Http\Controllers\Messages\MessageController@show')->name('parent.messages.show');
        Route::post('parent/messages/delete', 'App\Http\Controllers\Messages\MessageController@destroy')->name('parent.messages.destroy');
    }
);