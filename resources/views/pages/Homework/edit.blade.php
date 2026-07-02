@extends('layouts.master')
@section('PageTitle', 'تعديل واجب')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5>تعديل الواجب</h5></div>
        <div class="card-body">
            <form action="{{ route('homeworks.update', $homework->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="id" value="{{ $homework->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>العنوان (عربي)</label><input type="text" name="title[ar]" class="form-control" value="{{ $homework->getTranslation('title', 'ar') }}" required></div>
                        <div class="form-group"><label>العنوان (إنجليزي)</label><input type="text" name="title[en]" class="form-control" value="{{ $homework->getTranslation('title', 'en') }}" required></div>
                        <div class="form-group"><label>الوصف (عربي)</label><textarea name="description[ar]" class="form-control" rows="3">{{ $homework->getTranslation('description', 'ar') }}</textarea></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>المادة</label>
                            <select name="subject_id" class="form-control" required>
                                <option value="">اختر...</option>
                                @foreach($subjects as $s)<option value="{{ $s->id }}" {{ $homework->subject_id == $s->id ? 'selected' : '' }}>{{ $s->getTranslation('name', 'ar') }}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>القسم</label>
                            <select name="section_id" class="form-control" required>
                                <option value="">اختر...</option>
                                @foreach($sections as $sec)<option value="{{ $sec->id }}" {{ $homework->section_id == $sec->id ? 'selected' : '' }}>{{ $sec->getTranslation('Name_Section', 'ar') }}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>الموعد النهائي</label><input type="date" name="deadline" class="form-control" value="{{ $homework->deadline->format('Y-m-d') }}" required></div>
                        <div class="form-group"><label>ملف (اختياري)</label>
                            @if($homework->file)<br><small>الملف الحالي: <a href="{{ asset('attachments/homeworks/'.$homework->file) }}" target="_blank">تحميل</a></small>@endif
                            <input type="file" name="file" class="form-control mt-1">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> تحديث</button>
                <a href="{{ route('homeworks.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection