@extends('layouts.master')
@section('PageTitle', 'السجل السلوكي')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> السجل السلوكي</h5>
            <a href="{{ route('behavioral.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> إضافة سجل</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>#</th><th>الطالب</th><th>النوع</th><th>الوصف</th><th>النقاط</th><th>المعلم</th><th>التاريخ</th><th>إجراءات</th></tr></thead>
                    <tbody>
                    @foreach($records as $rec)
                    <tr>
                        <td>{{ $rec->id }}</td>
                        <td>{{ $rec->student ? $rec->student->getTranslation('name', 'ar') : '-' }}</td>
                        <td>
                            @if($rec->type == 'positive')
                                <span class="badge badge-success">إيجابي</span>
                            @else
                                <span class="badge badge-danger">سلبي</span>
                            @endif
                        </td>
                        <td>{{ $rec->description }}</td>
                        <td>{{ $rec->points }}</td>
                        <td>{{ $rec->teacher ? $rec->teacher->getTranslation('name', 'ar') : '-' }}</td>
                        <td>{{ $rec->date->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('behavioral.destroy') }}" method="POST" style="display:inline" onsubmit="return confirm('حذف؟')">
                                @csrf <input type="hidden" name="id" value="{{ $rec->id }}">
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