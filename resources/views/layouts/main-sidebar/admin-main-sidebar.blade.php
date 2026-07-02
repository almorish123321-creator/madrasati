<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <li>
            <a href="{{ url('/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">{{trans('main_trans.Dashboard')}}</span></div>
                <div class="clearfix"></div>
            </a>
        </li>
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Programname')}} </li>

        <!-- Grades-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Grades-menu">
                <div class="pull-left"><i class="fas fa-school"></i><span class="right-nav-text">{{trans('main_trans.Grades')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Grades-menu" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{route('Grades.index')}}">{{trans('main_trans.Grades_list')}}</a></li>
            </ul>
        </li>

        <!-- classes-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#classes-menu">
                <div class="pull-left"><i class="fa fa-building"></i><span class="right-nav-text">{{trans('main_trans.classes')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="classes-menu" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{route('Classrooms.index')}}">{{trans('main_trans.List_classes')}}</a></li>
            </ul>
        </li>

        <!-- sections-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#sections-menu">
                <div class="pull-left"><i class="fas fa-chalkboard"></i><span class="right-nav-text">{{trans('main_trans.sections')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="sections-menu" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{route('Sections.index')}}">{{trans('main_trans.List_sections')}}</a></li>
            </ul>
        </li>

        <!-- students-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#students-menu"><i class="fas fa-user-graduate"></i>{{trans('main_trans.students')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
            <ul id="students-menu" class="collapse">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#Student_information">{{trans('main_trans.Student_information')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
                    <ul id="Student_information" class="collapse">
                        <li> <a href="{{route('Students.create')}}">{{trans('main_trans.add_student')}}</a></li>
                        <li> <a href="{{route('Students.index')}}">{{trans('main_trans.list_students')}}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#Students_upgrade">{{trans('main_trans.Students_Promotions')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
                    <ul id="Students_upgrade" class="collapse">
                        <li> <a href="{{route('Promotion.index')}}">{{trans('main_trans.add_Promotion')}}</a></li>
                        <li> <a href="{{route('Promotion.create')}}">{{trans('main_trans.list_Promotions')}}</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#Graduate-students">{{trans('main_trans.Graduate_students')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
                    <ul id="Graduate-students" class="collapse">
                        <li> <a href="{{route('Graduated.create')}}">{{trans('main_trans.add_Graduate')}}</a> </li>
                        <li> <a href="{{route('Graduated.index')}}">{{trans('main_trans.list_Graduate')}}</a> </li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- Teachers-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Teachers-menu">
                <div class="pull-left"><i class="fas fa-chalkboard-teacher"></i></i><span class="right-nav-text">{{trans('main_trans.Teachers')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Teachers-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('Teachers.index')}}">{{trans('main_trans.List_Teachers')}}</a> </li>
                <li> <a href="{{route('teachers.import_form')}}">استيراد معلمين</a> </li>
            </ul>
        </li>

        <!-- Parents-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Parents-menu">
                <div class="pull-left"><i class="fas fa-user-tie"></i><span class="right-nav-text">{{trans('main_trans.Parents')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Parents-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{url('add_parent')}}">{{trans('main_trans.List_Parents')}}</a> </li>
            </ul>
        </li>

        <!-- Accounts-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Accounts-menu">
                <div class="pull-left"><i class="fas fa-money-bill-wave-alt"></i><span class="right-nav-text">{{trans('main_trans.Accounts')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Accounts-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('Fees.index')}}">الرسوم الدراسية</a> </li>
                <li> <a href="{{route('Fees_Invoices.index')}}">الفواتير</a> </li>
                <li> <a href="{{route('receipt_students.index')}}">سندات القبض</a> </li>
                <li> <a href="{{route('ProcessingFee.index')}}">استبعاد رسوم</a> </li>
                <li> <a href="{{route('Payment_students.index')}}">سندات الصرف</a> </li>
            </ul>
        </li>

        <!-- Attendance-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Attendance-icon">
                <div class="pull-left"><i class="fas fa-calendar-alt"></i><span class="right-nav-text">{{trans('main_trans.Attendance')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Attendance-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('Attendance.index')}}">تسجيل الحضور</a> </li>
                <li> <a href="{{route('attendance.import_form')}}">استيراد حضور</a> </li>
            </ul>
        </li>

        <!-- Subjects-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Subjects">
                <div class="pull-left"><i class="fas fa-book-open"></i><span class="right-nav-text">المواد الدراسية</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Subjects" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('subjects.index')}}">قائمة المواد</a> </li>
            </ul>
        </li>

        <!-- Quizzes-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Exams-icon">
                <div class="pull-left"><i class="fas fa-book-open"></i><span class="right-nav-text">الاختبارات</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Exams-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('Quizzes.index')}}">قائمة الاختبارات</a> </li>
                <li> <a href="{{route('Questions.index')}}">قائمة الأسئلة</a> </li>
                <li> <a href="{{route('grades.import_form')}}">استيراد درجات</a> </li>
            </ul>
        </li>

        <!-- Import & Export -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#ImportExport-menu">
                <div class="pull-left"><i class="fas fa-file-import"></i><span class="right-nav-text">استيراد وتصدير</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="ImportExport-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('students.import_form')}}">استيراد طلاب</a> </li>
                <li> <a href="{{route('export.students_excel')}}">تصدير طلاب Excel</a> </li>
                <li> <a href="{{route('export.teachers_excel')}}">تصدير معلمين Excel</a> </li>
                <li> <a href="{{route('export.fees_excel')}}">تصدير فواتير Excel</a> </li>
            </ul>
        </li>

        <!-- Homework -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Homework-menu">
                <div class="pull-left"><i class="fas fa-tasks"></i><span class="right-nav-text">الواجبات المنزلية</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Homework-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('homeworks.index')}}">قائمة الواجبات</a> </li>
            </ul>
        </li>

        <!-- Behavioral -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Behavioral-menu">
                <div class="pull-left"><i class="fas fa-clipboard-list"></i><span class="right-nav-text">التقييم السلوكي</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Behavioral-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('behavioral.index')}}">السجل السلوكي</a> </li>
            </ul>
        </li>

        <!-- Transportation -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Transportation-menu">
                <div class="pull-left"><i class="fas fa-bus"></i><span class="right-nav-text">المواصلات</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Transportation-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('buses.index')}}">إدارة الحافلات</a> </li>
            </ul>
        </li>

        <!-- Messages -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Messages-menu">
                <div class="pull-left"><i class="fas fa-envelope"></i><span class="right-nav-text">الرسائل الداخلية</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Messages-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('messages.inbox')}}">الوارد</a> </li>
                <li> <a href="{{route('messages.sent')}}">الصادر</a> </li>
                <li> <a href="{{route('messages.create')}}">رسالة جديدة</a> </li>
            </ul>
        </li>

        <!-- library-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#library-icon">
                <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">{{trans('main_trans.library')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="library-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('library.index')}}">قائمة الكتب</a> </li>
            </ul>
        </li>

        <!-- Online classes-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Onlineclasses-icon">
                <div class="pull-left"><i class="fas fa-video"></i><span class="right-nav-text">{{trans('main_trans.Onlineclasses')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Onlineclasses-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('online_classes.index')}}">حصص أونلاين مع زوم</a> </li>
            </ul>
        </li>

        <!-- Activity Log -->
        <li>
            <a href="{{route('activity-log.index')}}"><i class="fas fa-history"></i><span class="right-nav-text">سجل العمليات</span></a>
        </li>

        <!-- Backup -->
        <li>
            <a href="{{route('backup.index')}}"><i class="fas fa-database"></i><span class="right-nav-text">النسخ الاحتياطي</span></a>
        </li>

        <!-- Settings-->
        <li>
            <a href="{{route('settings.index')}}"><i class="fas fa-cogs"></i><span class="right-nav-text">{{trans('main_trans.Settings')}} </span></a>
        </li>
    </ul>
</div>