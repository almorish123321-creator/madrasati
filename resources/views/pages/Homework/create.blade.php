@extends('layouts.master')
@section('PageTitle', 'إضافة واجب')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5>إضافة واجب جديد</h5></div>
        <div class="card-body">
            <form action="{{ route('homeworks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>العنوان (عربي)</label><input type="text" name="title[ar]" class="form-control" required></div>
                        <div class="form-group"><label>العنوان (إنجليزي)</label><input type="text" name="title[en]" class="form-control" required></div>
                        <div class="form-group"><label>الوصف (عربي)</label><textarea name="description[ar]" class="form-control" rows="3"></textarea></div>
                        <div class="form-group"><label>الوصف (إنجليزي)</label><textarea name="description[en]" class="form-control" rows="3"></textarea></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>المادة</label>
                            <select name="subject_id" class="form-control" required>
                                <option value="">اختر...</option>
                                @foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->getTranslation('name', 'ar') }}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>المرحلة</label>
                            <select name="grade_id" class="form-control" required id="gradeSelect">
                                <option value="">اختر...</option>
                                @foreach($grades as $g)<option value="{{ $g->id }}">{{ $g->getTranslation('Name_Grade', 'ar') }}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>القسم</label>
                            <select name="section_id" class="form-control" required>
                                <option value="">اختر المرحلة أولاً</option>
                                @foreach($sections as $sec)<option value="{{ $sec->id }}">{{ $sec->getTranslation('Name_Section', 'ar') }}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>الموعد النهائي</label><input type="date" name="deadline" class="form-control" required></div>
                        <div class="form-group"><label>ملف (اختياري)</label><input type="file" name="file" class="form-control"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ</button>
                <a href="{{ route('homeworks.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection