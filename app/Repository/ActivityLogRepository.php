<?php

namespace App\Repository;

use Spatie\Activitylog\Models\Activity;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function index()
    {
        $activities = Activity::with('causer')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        return view('pages.ActivityLog.index', compact('activities'));
    }

    public function clear()
    {
        Activity::query()->delete();
        toastr()->success(trans('messages.Delete'));
        return redirect()->route('activity-log.index');
    }
}