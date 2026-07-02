<?php

namespace App\Http\Controllers\Backup;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        $backupPath = storage_path('app/Laravel');
        $files = [];
        if (File::isDirectory($backupPath)) {
            $files = collect(File::allFiles($backupPath))
                ->sortByDesc(function ($file) {
                    return $file->getMTime();
                })
                ->map(function ($file) {
                    return [
                        'name' => $file->getFilename(),
                        'path' => $file->getPathname(),
                        'size' => round($file->getSize() / 1024 / 1024, 2) . ' MB',
                        'date' => date('Y-m-d H:i:s', $file->getMTime()),
                    ];
                });
        }
        return view('pages.Backup.index', compact('files'));
    }

    public function create()
    {
        try {
            Artisan::call('backup:run --only-db');
            toastr()->success('تم إنشاء النسخة الاحتياطية بنجاح');
        } catch (\Exception $e) {
            toastr()->error('حدث خطأ: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    public function download($fileName)
    {
        $path = storage_path('app/Laravel/' . $fileName);
        if (File::exists($path)) {
            return response()->download($path);
        }
        toastr()->error('الملف غير موجود');
        return redirect()->back();
    }

    public function delete($fileName)
    {
        $path = storage_path('app/Laravel/' . $fileName);
        if (File::exists($path)) {
            File::delete($path);
            toastr()->success('تم حذف النسخة الاحتياطية');
        }
        return redirect()->back();
    }
}