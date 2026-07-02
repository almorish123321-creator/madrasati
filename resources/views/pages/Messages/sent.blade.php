@extends('layouts.master')

@section('PageTitle', 'صندوق الصادر')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-paper-plane"></i> صندوق الصادر</h5>
            <a href="{{ route('messages.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> رسالة جديدة
            </a>
        </div>
        <div class="card-body">
            <div class="list-group">
                @forelse($messages as $message)
                <a href="{{ route('messages.show', $message->id) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $message->subject }}</strong>
                            <br><small class="text-muted">إلى: {{ $message->receiver->name ?? 'مستخدم' }}</small>
                        </div>
                        <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                </a>
                @empty
                <div class="alert alert-info">لا توجد رسائل مرسلة</div>
                @endforelse
            </div>
            <div class="mt-3">{{ $messages->links() }}</div>
        </div>
    </div>
</div>
@endsection