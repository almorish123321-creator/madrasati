@extends('layouts.master')

@section('PageTitle', 'استيراد الدرجات')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>استيراد الدرجات من إكسل</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                الملف يجب أن يحتوي على: student_id, quizze_id, degree
            </div>
            <div class="mb-3">
                <a href="{{ route('grades.download_template') }}" class="btn btn-success">
                    <i class="fa fa-download"></i> تحميل نموذج الاستيراد
                </a>
            </div>
            <form action="{{ route('grades.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>ملف إكسل</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-upload"></i> استيراد
                </button>
            </form>
        </div>
    </div>
</div>
@endsection