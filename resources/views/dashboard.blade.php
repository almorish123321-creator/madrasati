<!DOCTYPE html>
<html lang="ar" dir="rtl">
@section('title')
    {{ trans('main_trans.Main_title') }}
@stop

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    @include('layouts.head')
    @livewireStyles
</head>

<body style="font-family: 'Cairo', sans-serif">
    <div class="wrapper" style="font-family: 'Cairo', sans-serif">
        <div id="pre-loader">
            <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
        </div>
        @include('layouts.main-header')
        @include('layouts.main-sidebar')

        <div class="content-wrapper">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="mb-0" style="font-family: 'Cairo', sans-serif">لوحة تحكم المدير</h4>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left"><span class="text-success"><i class="fas fa-user-graduate highlight-icon"></i></span></div>
                                <div class="float-right text-right">
                                    <p class="card-text text-dark">عدد الطلاب</p>
                                    <h4>{{ $totalStudents ?? \App\Models\Student::count() }}</h4>
                                </div>
                            </div>
                            <p class="text-muted pt-3 mb-0 mt-2 border-top">
                                <i class="fas fa-binoculars mr-1"></i><a href="{{ route('Students.index') }}" target="_blank"><span class="text-danger">عرض البيانات</span></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left"><span class="text-warning"><i class="fas fa-chalkboard-teacher highlight-icon"></i></span></div>
                                <div class="float-right text-right">
                                    <p class="card-text text-dark">عدد المعلمين</p>
                                    <h4>{{ $totalTeachers ?? \App\Models\Teacher::count() }}</h4>
                                </div>
                            </div>
                            <p class="text-muted pt-3 mb-0 mt-2 border-top">
                                <i class="fas fa-binoculars mr-1"></i><a href="{{ route('Teachers.index') }}" target="_blank"><span class="text-danger">عرض البيانات</span></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left"><span class="text-success"><i class="fas fa-user-tie highlight-icon"></i></span></div>
                                <div class="float-right text-right">
                                    <p class="card-text text-dark">عدد أولياء الأمور</p>
                                    <h4>{{ \App\Models\My_Parent::count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left"><span class="text-primary"><i class="fas fa-chalkboard highlight-icon"></i></span></div>
                                <div class="float-right text-right">
                                    <p class="card-text text-dark">الأقسام</p>
                                    <h4>{{ $totalSections ?? \App\Models\Section::count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row mb-30">
                <div class="col-xl-6 col-lg-6 mb-30">
                    <div class="card">
                        <div class="card-header"><h5>نسبة الحضور الشهرية</h5></div>
                        <div class="card-body"><canvas id="attendanceChart" height="250"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 mb-30">
                    <div class="card">
                        <div class="card-header"><h5>الطلاب حسب المرحلة</h5></div>
                        <div class="card-body"><canvas id="gradesChart" height="250"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-xl-12 mb-30">
                    <div class="card">
                        <div class="card-header"><h5>أفضل 10 طلاب درجات</h5></div>
                        <div class="card-body"><canvas id="topStudentsChart" height="200"></canvas></div>
                    </div>
                </div>
            </div>

            <!-- Recent Operations -->
            <div class="row">
                <div style="height: 400px;" class="col-xl-12 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <div class="tab nav-border">
                                <div class="d-block d-md-flex justify-content-between">
                                    <h5 style="font-family: 'Cairo', sans-serif" class="card-title">آخر العمليات</h5>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#students" role="tab">الطلاب</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#teachers" role="tab">المعلمين</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#parents" role="tab">أولياء الأمور</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fee_invoices" role="tab">الفواتير</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="students" role="tabpanel">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-hover mb-0 text-center">
                                                <thead><tr class="table-info"><th>#</th><th>اسم الطالب</th><th>البريد</th><th>المرحلة</th><th>تاريخ الإضافة</th></tr></thead>
                                                <tbody>
                                                @forelse(\App\Models\Student::latest()->take(5)->get() as $student)
                                                    <tr><td>{{ $loop->iteration }}</td><td>{{ $student->name }}</td><td>{{ $student->email }}</td><td>{{ $student->grade->Name_Grade ?? '' }}</td><td class="text-success">{{ $student->created_at->format('Y-m-d') }}</td></tr>
                                                @empty
                                                    <tr><td colspan="5" class="alert-danger">لا توجد بيانات</td></tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="teachers" role="tabpanel">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-hover mb-0 text-center">
                                                <thead><tr class="table-info"><th>#</th><th>اسم المعلم</th><th>التخصص</th><th>تاريخ التعيين</th></tr></thead>
                                                <tbody>
                                                @forelse(\App\Models\Teacher::latest()->take(5)->get() as $teacher)
                                                    <tr><td>{{ $loop->iteration }}</td><td>{{ $teacher->name }}</td><td>{{ $teacher->specializations->Name ?? '' }}</td><td>{{ $teacher->Joining_Date }}</td></tr>
                                                @empty
                                                    <tr><td colspan="4" class="alert-danger">لا توجد بيانات</td></tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="parents" role="tabpanel">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-hover mb-0 text-center">
                                                <thead><tr class="table-info"><th>#</th><th>اسم ولي الأمر</th><th>البريد</th><th>الهاتف</th></tr></thead>
                                                <tbody>
                                                @forelse(\App\Models\My_Parent::latest()->take(5)->get() as $parent)
                                                    <tr><td>{{ $loop->iteration }}</td><td>{{ $parent->Name_Father }}</td><td>{{ $parent->email }}</td><td>{{ $parent->Phone_Father }}</td></tr>
                                                @empty
                                                    <tr><td colspan="4" class="alert-danger">لا توجد بيانات</td></tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="fee_invoices" role="tabpanel">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-hover mb-0 text-center">
                                                <thead><tr class="table-info"><th>#</th><th>الطالب</th><th>المبلغ</th><th>الحالة</th><th>التاريخ</th></tr></thead>
                                                <tbody>
                                                @forelse(\App\Models\Fee_invoice::latest()->take(5)->with('student')->get() as $inv)
                                                    <tr><td>{{ $loop->iteration }}</td><td>{{ $inv->student->name ?? '' }}</td><td>{{ $inv->amount }}</td><td>{{ $inv->invoice_status == 1 ? 'مدفوعة' : 'غير مدفوعة' }}</td><td>{{ $inv->created_at->format('Y-m-d') }}</td></tr>
                                                @empty
                                                    <tr><td colspan="5" class="alert-danger">لا توجد بيانات</td></tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <livewire:calendar />
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.footer-scripts')
    @livewireScripts
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
    @if(isset($attendanceTrend) && $attendanceTrend)
    new Chart(document.getElementById('attendanceChart'),{
        type:'line',
        data:{labels:[{!! json_encode(collect($attendanceTrend)->pluck('month')->toArray()) !!}],datasets:[{label:'نسبة الحضور %',data:[{!! json_encode(collect($attendanceTrend)->pluck('rate')->toArray()) !!}],borderColor:'#4caf50',backgroundColor:'rgba(76,175,80,0.1)',fill:true,tension:0.4}]},
        options:{responsive:true,plugins:{legend:{labels:{font:{family:'Cairo'}}}},scales:{y:{beginAtZero:true,max:100},x:{}}}
    });
    @endif
    @if(isset($studentsPerGrade) && $studentsPerGrade)
    new Chart(document.getElementById('gradesChart'),{
        type:'doughnut',
        data:{labels:[{!! json_encode($studentsPerGrade->pluck('Name_Grade')->toArray()) !!}],datasets:[{data:[{!! json_encode($studentsPerGrade->pluck('students_count')->toArray()) !!}],backgroundColor:['#1a73e8','#e91e63','#ff9800','#4caf50','#9c27b0','#00bcd4','#ff5722','#795548']}]},
        options:{responsive:true,plugins:{legend:{position:'bottom',labels:{font:{family:'Cairo'}}}}}
    });
    @endif
    @if(isset($topStudents) && $topStudents)
    new Chart(document.getElementById('topStudentsChart'),{
        type:'bar',
        data:{labels:[{!! json_encode($topStudents->pluck('name')->toArray()) !!}],datasets:[{label:'المعدل',data:[{!! json_encode($topStudents->pluck('avg')->toArray()) !!}],backgroundColor:'rgba(26,115,232,0.7)'}]},
        options:{responsive:true,indexAxis:'y',scales:{x:{beginAtZero:true,max:100},y:{}}}
    });
    @endif
    </script>
</body>
</html>