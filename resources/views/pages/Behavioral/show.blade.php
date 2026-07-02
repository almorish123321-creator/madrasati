@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0" style="font-family: 'Cairo', sans-serif">تفاصيل السجل السلوكي</h4>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('behavioral.index') }}" class="btn btn-primary btn-sm float-left">
                    <i class="fas fa-arrow-right"></i> العودة
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="25%">الطالب</th>
                                    <td>{{ $record->student->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>النوع</th>
                                    <td>
                                        @if($record->type == 'positive')
                                            <span class="badge badge-success">إيجابي</span>
                                        @else
                                            <span class="badge badge-danger">سلبي</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>النقاط</th>
                                    <td>{{ $record->points }}</td>
                                </tr>
                                <tr>
                                    <th>الوصف</th>
                                    <td>{{ $record->description }}</td>
                                </tr>
                                <tr>
                                    <th>المعلم</th>
                                    <td>{{ $record->teacher->Name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>التاريخ</th>
                                    <td>{{ $record->date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection