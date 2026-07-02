<?php

namespace App\Notifications;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class StudentAbsenceNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $date;

    public function __construct(Student $student, $date)
    {
        $this->student = $student;
        $this->date = $date;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'غياب طالب',
            'body' => 'تم تسجيل غياب ابنكم ' . $this->student->getTranslation('name', 'ar') . ' بتاريخ ' . $this->date,
            'student_id' => $this->student->id,
            'date' => $this->date,
            'icon' => 'fa-user-times',
            'color' => 'danger',
        ];
    }
}