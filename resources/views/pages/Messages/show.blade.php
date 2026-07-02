@extends('layouts.master')

@section('PageTitle', $message->subject)

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $message->subject }}</h5>
            <form action="{{ route('messages.destroy') }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                @csrf
                <input type="hidden" name="id" value="{{ $message->id }}">
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> حذف</button>
            </form>
        </div>
        <div class="card-body">
            <div class="mb-3 text-muted">
                <strong>من:</strong> {{ $message->sender->name ?? '-' }} &nbsp;
                <strong>إلى:</strong> {{ $message->receiver->name ?? '-' }} &nbsp;
                <strong>التاريخ:</strong> {{ $message->created_at->format('Y-m-d H:i') }}
            </div>
            <hr>
            <div style="white-space:pre-wrap;line-height:1.8;font-size:15px;">{{ $message->body }}</div>
            <hr>
            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">رجوع للوارد</a>
        </div>
    </div>
</div>
@endsection