@extends('layouts.master')

@section('PageTitle', 'أخطاء الاستيراد')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">أخطاء الاستيراد ({{ $errors->count() }} خطأ)</h5>
            <div>
                <a href="{{ route('import.download_errors') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-download"></i> تحميل ملف الأخطاء
                </a>
                <a href="{{ URL::previous() }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-redo"></i> إعادة المحاولة
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($errors->isEmpty())
                <div class="alert alert-success">تم الاستيراد بنجاح بدون أخطاء</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>الصف</th>
                                <th>الحقل</th>
                                <th>الخطأ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($errors as $error)
                            <tr>
                                <td>{{ $error['row'] ?? '-' }}</td>
                                <td>{{ $error['field'] ?? '-' }}</td>
                                <td class="text-danger">{{ $error['message'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection