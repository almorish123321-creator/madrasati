<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repository\TeacherRepositoryInterface',
            'App\Repository\TeacherRepository'
        );

        $this->app->bind(
            'App\Repository\StudentRepositoryInterface',
            'App\Repository\StudentRepository'
        );

        $this->app->bind(
            'App\Repository\StudentPromotionRepositoryInterface',
            'App\Repository\StudentPromotionRepository'
        );

        $this->app->bind(
            'App\Repository\StudentGraduatedRepositoryInterface',
            'App\Repository\StudentGraduatedRepository'
        );

        $this->app->bind(
            'App\Repository\FeesRepositoryInterface',
            'App\Repository\FeesRepository'
        );
        $this->app->bind(
            'App\Repository\FeeInvoicesRepositoryInterface',
            'App\Repository\FeeInvoicesRepository'
        );

        $this->app->bind(
            'App\Repository\ReceiptStudentsRepositoryInterface',
            'App\Repository\ReceiptStudentsRepository'
        );

        $this->app->bind(
            'App\Repository\ProcessingFeeRepositoryInterface',
            'App\Repository\ProcessingFeeRepository'
        );

        $this->app->bind(
            'App\Repository\PaymentRepositoryInterface',
            'App\Repository\PaymentRepository'
        );

        $this->app->bind(
            'App\Repository\AttendanceRepositoryInterface',
            'App\Repository\AttendanceRepository'
        );

        $this->app->bind(
            'App\Repository\SubjectRepositoryInterface',
            'App\Repository\SubjectRepository'
        );

        $this->app->bind(
            'App\Repository\QuizzRepositoryInterface',
            'App\Repository\QuizzRepository'
        );

        $this->app->bind(
            'App\Repository\QuestionRepositoryInterface',
            'App\Repository\QuestionRepository'
        );

        $this->app->bind(
            'App\Repository\LibraryRepositoryInterface',
            'App\Repository\LibraryRepository'
        );

        // New Repositories
        $this->app->bind(
            'App\Repository\ExportImportRepositoryInterface',
            'App\Repository\ExportImportRepository'
        );
        $this->app->bind(
            'App\Repository\NotificationRepositoryInterface',
            'App\Repository\NotificationRepository'
        );
        $this->app->bind(
            'App\Repository\MessageRepositoryInterface',
            'App\Repository\MessageRepository'
        );
        $this->app->bind(
            'App\Repository\HomeworkRepositoryInterface',
            'App\Repository\HomeworkRepository'
        );
        $this->app->bind(
            'App\Repository\BehavioralRecordRepositoryInterface',
            'App\Repository\BehavioralRecordRepository'
        );
        $this->app->bind(
            'App\Repository\BusRepositoryInterface',
            'App\Repository\BusRepository'
        );
        $this->app->bind(
            'App\Repository\ActivityLogRepositoryInterface',
            'App\Repository\ActivityLogRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
