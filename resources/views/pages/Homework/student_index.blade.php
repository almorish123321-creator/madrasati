@extends('layouts.master')
@section('PageTitle', 'الواجبات')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5><i class="fas fa-tasks"></i> واجباتي</h5></div>
        <div class="card-body">
            <div class="list-group">
                @forelse($homeworks as $hw)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>{{ $hw->getTranslation('title', 'ar') }}</h6>
                            <small class="text-muted">{{ $hw->subject ? $hw->subject->getTranslation('name', 'ar') : '' }} - الموعد: {{ $hw->deadline->format('Y-m-d') }}</small>
                            @if($hw->file)<br><a href="{{ asset('attachments/homeworks/'.$hw->file) }}" class="btn btn-sm btn-outline-info mt-1"><i class="fas fa-download"></i> تحميل الملف</a>@endif
                        </div>
                        <div>
                            @if($hw->submissions->count() > 0)
                                <span class="badge badge-success">تم التسليم</span>
                            @else
                                <form action="{{ route('student.homeworks.submit') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                    @csrf <input type="hidden" name="homework_id" value="{{ $hw->id }}">
                                    <input type="file" name="file" class="form-control form-control-sm mb-1" accept=".pdf,.doc,.docx,.jpg,.png">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i> تسليم</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">لا توجد واجبات حالياً</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection