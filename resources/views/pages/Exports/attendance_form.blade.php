@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تصدير الحضور والغياب
@stop
@endsection
@section('page-header')
@section('PageTitle')
    تصدير الحضور والغياب - {{ $classroom->Name_Class }}
@stop
@endsection
@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <h5 style="font-family: 'Cairo', sans-serif;" class="mb-20 text-center">
                    <i class="fas fa-calendar-alt"></i>
                    تصدير سجل الحضور والغياب
                </h5>
                <p class="text-center text-muted mb-30">
                    الصف: <strong>{{ $classroom->Name_Class }}</strong>
                </p>

                <form action="{{ route('students.export_attendance', $classroom->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label style="font-family: 'Cairo', sans-serif;">اختر الشهر</label>
                        <select name="month" class="form-control" required>
                            <option value="">-- اختر الشهر --</option>
                            <option value="1">يناير</option>
                            <option value="2">فبراير</option>
                            <option value="3">مارس</option>
                            <option value="4">أبريل</option>
                            <option value="5">مايو</option>
                            <option value="6">يونيو</option>
                            <option value="7">يوليو</option>
                            <option value="8">أغسطس</option>
                            <option value="9">سبتمبر</option>
                            <option value="10">أكتوبر</option>
                            <option value="11">نوفمبر</option>
                            <option value="12">ديسمبر</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="font-family: 'Cairo', sans-serif;">اختر السنة</label>
                        <input type="number" name="year" class="form-control"
                               value="{{ date('Y') }}" min="2020" max="2030" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-file-excel"></i>
                        تصدير إلى Excel
                    </button>

                    <a href="{{ route('Classrooms.index') }}" class="btn btn-secondary btn-block mt-10">
                        <i class="fas fa-arrow-right"></i>
                        العودة
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection