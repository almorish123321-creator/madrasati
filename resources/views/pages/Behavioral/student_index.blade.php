@extends('layouts.master')
@section('PageTitle', 'سجلي السلوكي')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5><i class="fas fa-clipboard-list"></i> سجلي السلوكي</h5></div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6"><div class="alert alert-success"><i class="fas fa-plus-circle"></i> الإيجابي: {{ $records->where('type','positive')->sum('points') }} نقطة</div></div>
                <div class="col-md-6"><div class="alert alert-danger"><i class="fas fa-minus-circle"></i> السلبي: {{ $records->where('type','negative')->sum('points') }} نقطة</div></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>النوع</th><th>الوصف</th><th>النقاط</th><th>المعلم</th><th>التاريخ</th></tr></thead>
                    <tbody>
                    @foreach($records as $rec)
                    <tr>
                        <td>{{ $rec->type == 'positive' ? '<span class="badge badge-success">إيجابي</span>' : '<span class="badge badge-danger">سلبي</span>' }}</td>
                        <td>{{ $rec->description }}</td>
                        <td>{{ $rec->points }}</td>
                        <td>{{ $rec->teacher ? $rec->teacher->getTranslation('name', 'ar') : '-' }}</td>
                        <td>{{ $rec->date->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection