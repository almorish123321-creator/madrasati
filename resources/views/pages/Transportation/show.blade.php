@extends('layouts.master')
@section('PageTitle', 'تفاصيل الحافلة')
@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header"><h5>{{ $bus->name }} - {{ $bus->driver }}</h5></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><strong>المسار:</strong> {{ $bus->route ?? '-' }}</div>
                <div class="col-md-3"><strong>السعة:</strong> {{ $bus->capacity }}</div>
                <div class="col-md-3"><strong>المسجلين:</strong> {{ $students->count() }}</div>
                <div class="col-md-3">
                    <form action="{{ route('buses.assign') }}" method="POST" class="form-inline">
                        @csrf <input type="hidden" name="bus_id" value="{{ $bus->id }}">
                        <select name="student_id" class="form-control form-control-sm" required>
                            <option value="">أضف طالب...</option>
                            @foreach($allStudents as $s)<option value="{{ $s->id }}">{{ $s->getTranslation('name', 'ar') }}</option>@endforeach
                        </select>
                        <button class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h5>الطلاب المسجلين</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>#</th><th>الطالب</th><th>نقطة الاصطياف</th><th>نقطة الإنزال</th><th>إجراءات</th></tr></thead>
                    <tbody>
                    @foreach($students as $s)
                    <tr>
                        <td>{{ $s->id }}</td>
                        <td>{{ $s->getTranslation('name', 'ar') }}</td>
                        <td>{{ $s->pivot->pickup_point ?? '-' }}</td>
                        <td>{{ $s->pivot->dropoff_point ?? '-' }}</td>
                        <td>
                            <form action="{{ route('buses.remove') }}" method="POST" style="display:inline" onsubmit="return confirm('إزالة؟')">
                                @csrf <input type="hidden" name="student_id" value="{{ $s->id }}">
                                <input type="hidden" name="bus_id" value="{{ $bus->id }}">
                                <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
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