@extends('layouts.master')
@section('PageTitle', 'تعديل حافلة')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h5>تعديل بيانات الحافلة</h5></div>
        <div class="card-body">
            <form action="{{ route('buses.update') }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="id" value="{{ $bus->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>اسم الحافلة</label><input type="text" name="name" class="form-control" value="{{ $bus->name }}" required></div>
                        <div class="form-group"><label>السائق</label><input type="text" name="driver" class="form-control" value="{{ $bus->driver ?? '' }}"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>الهاتف</label><input type="text" name="phone" class="form-control" value="{{ $bus->phone ?? '' }}"></div>
                        <div class="form-group"><label>المسار</label><input type="text" name="route" class="form-control" value="{{ $bus->route ?? '' }}"></div>
                        <div class="form-group"><label>السعة</label><input type="number" name="capacity" class="form-control" value="{{ $bus->capacity }}" min="1"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> تحديث</button>
                <a href="{{ route('buses.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection