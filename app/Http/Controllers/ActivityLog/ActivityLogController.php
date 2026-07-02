<?php

namespace App\Http\Controllers\ActivityLog;

use App\Http\Controllers\Controller;
use App\Repository\ActivityLogRepositoryInterface;

class ActivityLogController extends Controller
{
    protected $activityLog;

    public function __construct(ActivityLogRepositoryInterface $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function index()
    {
        return $this->activityLog->index();
    }

    public function clear()
    {
        return $this->activityLog->clear();
    }
}