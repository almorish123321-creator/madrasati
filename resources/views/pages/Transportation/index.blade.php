@extends('layouts.master')
@section('PageTitle', 'إدارة الحافلات')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-bus"></i> إدارة المواصلات</h5>
            <a href="{{ route('buses.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> حافلة جديدة</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>#</th><th>اسم الحافلة</th><th>السائق</th><th>الهاتف</th><th>المسار</th><th>السعة</th><th>عدد الطلاب</th><th>إجراءات</th></tr></thead>
                    <tbody>
                    @foreach($buses as $bus)
                    <tr>
                        <td>{{ $bus->id }}</td>
                        <td>{{ $bus->name }}</td>
                        <td>{{ $bus->driver ?? '-' }}</td>
                        <td>{{ $bus->phone ?? '-' }}</td>
                        <td>{{ $bus->route ?? '-' }}</td>
                        <td>{{ $bus->capacity }}</td>
                        <td><span class="badge badge-info">{{ $bus->students_count }}</span></td>
                        <td>
                            <a href="{{ route('buses.show', $bus->id) }}" class="btn btn-info btn-sm"><i class="fas fa-users"></i></a>
                            <a href="{{ route('buses.edit', $bus->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('buses.destroy') }}" method="POST" style="display:inline" onsubmit="return confirm('حذف؟')">
                                @csrf <input type="hidden" name="id" value="{{ $bus->id }}">
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection