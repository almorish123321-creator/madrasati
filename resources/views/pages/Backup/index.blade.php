@extends('layouts.master')
@section('PageTitle', 'النسخ الاحتياطي')
@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-database"></i> النسخ الاحتياطي</h5>
            <form action="{{ route('backup.create') }}" method="POST" onsubmit="return confirm('إنشاء نسخة احتياطية جديدة؟')">
                @csrf
                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> إنشاء نسخة احتياطية</button>
            </form>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                يتم إنشاء نسخة احتياطية تلقائية يومياً لقاعدة البيانات. يمكنك أيضاً إنشاء نسخة يدوية من هنا.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>#</th><th>اسم الملف</th><th>الحجم</th><th>التاريخ</th><th>إجراءات</th></tr></thead>
                    <tbody>
                    @forelse($files as $file)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $file['name'] }}</td>
                        <td>{{ $file['size'] }}</td>
                        <td>{{ $file['date'] }}</td>
                        <td>
                            <a href="{{ route('backup.download', $file['name']) }}" class="btn btn-info btn-sm"><i class="fas fa-download"></i></a>
                            <form action="{{ route('backup.delete', $file['name']) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف النسخة؟')">
                                @csrf
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">لا توجد نسخ احتياطية</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection