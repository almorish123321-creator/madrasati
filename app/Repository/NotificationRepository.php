<?php

namespace App\Repository;

use App\Models\Student;
use App\Models\Teacher;
use App\Notifications\StudentAbsenceNotification;
use App\Notifications\NewGradeNotification;
use App\Notifications\FeeDueNotification;
use App\Notifications\NewQuizNotification;
use App\Notifications\NewStudentInSectionNotification;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function getUnreadCount($userId)
    {
        return \Illuminate\Support\Facades\Auth::user()->unreadNotifications()->count();
    }

    public function getUserNotifications($userId)
    {
        return \Illuminate\Support\Facades\Auth::user()->notifications()->orderBy('created_at', 'desc')->paginate(20);
    }

    public function markAsRead($notificationId)
    {
        \Illuminate\Support\Facades\Auth::user()->unreadNotifications->where('id', $notificationId)->markAsRead();
    }

    public function markAllAsRead($userId)
    {
        \Illuminate\Support\Facades\Auth::user()->unreadNotifications->markAsRead();
    }

    public function notifyAbsence($studentId, $date)
    {
        $student = Student::findOrFail($studentId);
        if ($student->parent_id) {
            $parent = \App\Models\My_Parent::find($student->parent_id);
            if ($parent) {
                $parent->notify(new StudentAbsenceNotification($student, $date));
            }
        }
    }

    public function notifyNewGrade($studentId, $subjectName, $degree)
    {
        $student = Student::findOrFail($studentId);
        if ($student->parent_id) {
            $parent = \App\Models\My_Parent::find($student->parent_id);
            if ($parent) {
                $parent->notify(new NewGradeNotification($student, $subjectName, $degree));
            }
        }
    }

    public function notifyFeeDue($studentId, $feeName, $amount)
    {
        $student = Student::findOrFail($studentId);
        if ($student->parent_id) {
            $parent = \App\Models\My_Parent::find($student->parent_id);
            if ($parent) {
                $parent->notify(new FeeDueNotification($student, $feeName, $amount));
            }
        }
    }

    public function notifyNewQuiz($studentIds, $quizName, $subjectName)
    {
        foreach ($studentIds as $studentId) {
            $student = Student::find($studentId);
            if ($student) {
                $student->notify(new NewQuizNotification($student, $quizName, $subjectName));
            }
        }
    }

    public function notifyNewStudent($teacherId, $studentName)
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $teacher->notify(new NewStudentInSectionNotification($studentName));
        }
    }
}