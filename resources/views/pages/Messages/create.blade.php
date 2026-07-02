@extends('layouts.master')

@section('PageTitle', 'رسالة جديدة')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5><i class="fas fa-envelope"></i> رسالة جديدة</h5></div>
        <div class="card-body">
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>إلى</label>
                    <select name="to_id" class="form-control" required>
                        <option value="">اختر المستلم...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>الموضوع</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                </div>
                <div class="form-group">
                    <label>نص الرسالة</label>
                    <textarea name="body" class="form-control" rows="6" required>{{ old('body') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> إرسال</button>
                <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection