<?php

namespace App\Notifications;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FeeDueNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $feeName;
    protected $amount;

    public function __construct(Student $student, $feeName, $amount)
    {
        $this->student = $student;
        $this->feeName = $feeName;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'رسوم مستحقة',
            'body' => 'استحقق رسوم ' . $this->feeName . ' بمبلغ ' . $this->amount . ' ريال لابنكم ' . $this->student->getTranslation('name', 'ar'),
            'student_id' => $this->student->id,
            'icon' => 'fa-money-bill',
            'color' => 'warning',
        ];
    }
}