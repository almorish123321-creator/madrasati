@extends('layouts.master')
@section('PageTitle', 'إضافة سجل سلوكي')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5>إضافة سجل سلوكي جديد</h5></div>
        <div class="card-body">
            <form action="{{ route('behavioral.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group"><label>الطالب</label>
                            <select name="student_id" class="form-control" required>
                                <option value="">اختر الطالب...</option>
                                @foreach($students as $s)<option value="{{ $s->id }}">{{ $s->getTranslation('name', 'ar') }}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>النوع</label>
                            <select name="type" class="form-control" required>
                                <option value="positive">إيجابي</option>
                                <option value="negative">سلبي</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label>النقاط</label><input type="number" name="points" class="form-control" min="0" required></div>
                        <div class="form-group"><label>التاريخ</label><input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label>الوصف</label><textarea name="description" class="form-control" rows="4" required></textarea></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ</button>
                <a href="{{ route('behavioral.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection