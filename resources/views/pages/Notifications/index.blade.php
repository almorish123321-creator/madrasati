@extends('layouts.master')
@section('PageTitle', 'الإشعارات')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-bell"></i> الإشعارات</h5>
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-secondary"><i class="fas fa-check-double"></i> تعيين الكل كمقروء</button>
            </form>
        </div>
        <div class="card-body">
            <div class="list-group">
                @forelse($notifications as $notification)
                <?php $data = $notification->data; ?>
                <div class="list-group-item {{ $notification->read_at ? '' : 'font-weight-bold bg-light' }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            @if(!$notification->read_at)
                                <a href="{{ route('notifications.markRead', $notification->id) }}" class="badge badge-primary mr-2" style="font-size:10px;">غير مقروء</a>
                            @endif
                            <i class="fas {{ $data['icon'] ?? 'fa-bell' }} text-{{ $data['color'] ?? 'info' }} ml-2"></i>
                            <strong>{{ $data['title'] ?? 'إشعار' }}</strong>
                            <p class="mb-1 mt-1">{{ $data['body'] ?? '' }}</p>
                        </div>
                        <small class="text-muted whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @empty
                <div class="alert alert-info text-center">لا توجد إشعارات</div>
                @endforelse
            </div>
            <div class="mt-3">{{ $notifications->links() }}</div>
        </div>
    </div>
</div>
@endsection