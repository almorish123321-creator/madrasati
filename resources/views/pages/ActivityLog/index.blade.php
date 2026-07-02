@extends('layouts.master')
@section('PageTitle', 'سجل العمليات')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-history"></i> سجل العمليات</h5>
            <form action="{{ route('activity-log.clear') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من مسح السجل؟')">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> مسح السجل</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr><th>#</th><th>المستخدم</th><th>العملية</th><th>التفاصيل</th><th>التاريخ</th></tr>
                    </thead>
                    <tbody>
                    @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->id }}</td>
                        <td>{{ $activity->causer ? $activity->causer->name : 'نظام' }}</td>
                        <td><span class="badge badge-{{ $activity->event == 'created' ? 'success' : ($activity->event == 'updated' ? 'warning' : 'danger') }}">{{ $activity->event }}</span></td>
                        <td>
                            @if($activity->subject_type)
                                <small>{{ class_basename($activity->subject_type) }} #{{ $activity->subject_id ?? '' }}</small>
                            @endif
                            @if($activity->properties)
                                @php $props = is_string($activity->properties) ? json_decode($activity->properties, true) : $activity->properties->toArray(); @endphp
                                @if(isset($props['attributes']))
                                    <small class="text-muted"> {!! collect($props['attributes'])->except(['password','remember_token'])->map(function($v,$k){ return $k.':'.(is_array($v)?json_encode($v):$v); })->implode(' | ') !!}</small>
                                @endif
                            @endif
                        </td>
                        <td>{{ $activity->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $activities->links() }}</div>
        </div>
    </div>
</div>
@endsection