<?php

namespace App\Notifications;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewGradeNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $subjectName;
    protected $degree;

    public function __construct(Student $student, $subjectName, $degree)
    {
        $this->student = $student;
        $this->subjectName = $subjectName;
        $this->degree = $degree;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'درجة جديدة',
            'body' => 'حصل ابنكم ' . $this->student->getTranslation('name', 'ar') . ' على درجة ' . $this->degree . ' في مادة ' . $this->subjectName,
            'student_id' => $this->student->id,
            'icon' => 'fa-star',
            'color' => 'success',
        ];
    }
}