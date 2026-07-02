@extends('layouts.master')
@section('PageTitle', 'تسليمات الواجب')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5>تسليمات: {{ $homework->getTranslation('title', 'ar') }}</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>الطالب</th><th>التاريخ</th><th>الملف</th><th>ملاحظات</th></tr></thead>
                    <tbody>
                    @foreach($submissions as $sub)
                    <tr>
                        <td>{{ $sub->student->getTranslation('name', 'ar') }}</td>
                        <td>{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($sub->file)<a href="{{ asset('attachments/homework_submissions/'.$sub->file) }}" class="btn btn-sm btn-info"><i class="fas fa-download"></i></a>@else - @endif
                        </td>
                        <td>{{ $sub->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection