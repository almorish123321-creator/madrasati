@extends('layouts.master')
@section('PageTitle', 'الواجبات المنزلية')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-tasks"></i> الواجبات المنزلية</h5>
            <a href="{{ route('homeworks.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> واجب جديد</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>#</th><th>العنوان</th><th>المادة</th><th>القسم</th><th>الموعد النهائي</th><th>التسليمات</th><th>إجراءات</th></tr></thead>
                    <tbody>
                    @foreach($homeworks as $hw)
                    <tr>
                        <td>{{ $hw->id }}</td>
                        <td>{{ $hw->getTranslation('title', 'ar') }}</td>
                        <td>{{ $hw->subject ? $hw->subject->getTranslation('name', 'ar') : '-' }}</td>
                        <td>{{ $hw->section ? $hw->section->getTranslation('Name_Section', 'ar') : '-' }}</td>
                        <td>{{ $hw->deadline->format('Y-m-d') }}</td>
                        <td><span class="badge badge-info">{{ $hw->submissions->count() }}</span></td>
                        <td>
                            <a href="{{ route('homeworks.submissions', $hw->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('homeworks.edit', $hw->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('homeworks.destroy') }}" method="POST" style="display:inline" onsubmit="return confirm('حذف؟')">
                                @csrf <input type="hidden" name="id" value="{{ $hw->id }}">
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection