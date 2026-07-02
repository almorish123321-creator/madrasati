@extends('layouts.master')
@section('PageTitle', 'إضافة حافلة')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5>إضافة حافلة جديدة</h5></div>
        <div class="card-body">
            <form action="{{ route('buses.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>اسم الحافلة</label><input type="text" name="name" class="form-control" required></div>
                        <div class="form-group"><label>السائق</label><input type="text" name="driver" class="form-control"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>الهاتف</label><input type="text" name="phone" class="form-control"></div>
                        <div class="form-group"><label>المسار</label><input type="text" name="route" class="form-control"></div>
                        <div class="form-group"><label>السعة</label><input type="number" name="capacity" class="form-control" value="50" min="1"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ</button>
                <a href="{{ route('buses.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection