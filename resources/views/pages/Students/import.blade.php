@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ trans('main_trans.import_students_excel') }}
@stop
@endsection
@section('page-header')
@section('PageTitle')
    {{ trans('main_trans.import_students_excel') }}
@stop
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                {{-- رسائل الخطأ --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="alert alert-info">
                    <h5 style="font-family: 'Cairo', sans-serif;">
                        <i class="fas fa-info-circle"></i>
                        تعليمات الاستيراد
                    </h5>
                    <ul style="font-family: 'Cairo', sans-serif;">
                        <li>حمّل نموذج Excel أولاً واملأه ببيانات الطلاب</li>
                        <li>تأكد من أن أسماء المراحل والصفوف والأقسام مطابقة لما هو مسجل في النظام</li>
                        <li>الجنس: اكتب "ذكر" أو "أنثى"</li>
                        <li>الجنسية وفصيلة الدم: يجب أن تكون مسجلة مسبقاً في النظام</li>
                        <li>إذا كان البريد الإلكتروني مكرراً سيتم تخطي الطالب</li>
                        <li>كلمة المرور الافتراضية: 12345678</li>
                    </ul>
                </div>

                {{-- زر تحميل النموذج --}}
                <div class="mb-20">
                    <a href="{{ route('students.download_template') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-download"></i>
                        تحميل نموذج Excel فارغ
                    </a>
                </div>

                {{-- نموذج رفع الملف --}}
                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label style="font-family: 'Cairo', sans-serif;" for="file">
                            اختر ملف Excel (.xlsx, .xls, .csv)
                        </label>
                        <input type="file"
                               name="file"
                               id="file"
                               class="form-control"
                               accept=".xlsx,.xls,.csv"
                               required>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-import"></i>
                        استيراد البيانات
                    </button>
                    <a href="{{ route('Students.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i>
                        العودة لقائمة الطلاب
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