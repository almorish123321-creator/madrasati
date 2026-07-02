<?php

namespace App\Repository;

interface NotificationRepositoryInterface
{
    public function getUnreadCount($userId);
    public function getUserNotifications($userId);
    public function markAsRead($notificationId);
    public function markAllAsRead($userId);
    public function notifyAbsence($studentId, $date);
    public function notifyNewGrade($studentId, $subjectName, $degree);
    public function notifyFeeDue($studentId, $feeName, $amount);
    public function notifyNewQuiz($studentIds, $quizName, $subjectName);
    public function notifyNewStudent($teacherId, $studentName);
}