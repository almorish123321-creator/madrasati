<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        * { font-family: 'Cairo', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { direction: rtl; color: #333; font-size: 11px; }
        .container { max-width: 100%; margin: 0 auto; padding: 15px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px double #333; padding-bottom: 10px; margin-bottom: 10px; }
        .logo { width: 60px; height: 60px; }
        .school-name { font-size: 18px; font-weight: bold; color: #1a237e; }
        .title { text-align: center; font-size: 16px; font-weight: bold; color: #1a237e; margin: 10px 0; border: 1px solid #333; padding: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px 6px; text-align: center; }
        th { background: #1a237e; color: white; font-size: 10px; }
        .row-num { width: 30px; }
        .grade-excellent { background: #e8f5e9; font-weight: bold; color: #2e7d32; }
        .grade-very-good { background: #e3f2fd; font-weight: bold; color: #1565c0; }
        .grade-good { background: #fff8e1; font-weight: bold; color: #f57f17; }
        .grade-pass { background: #fce4ec; font-weight: bold; color: #c62828; }
        .grade-fail { background: #ffcdd2; font-weight: bold; color: #b71c1c; }
        .footer { margin-top: 30px; display: flex; justify-content: space-between; }
        .sig { text-align: center; }
        .sig .line { border-top: 1px solid #333; width: 100px; margin: 25px auto 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <div class="school-name">{{ $setting->school_name ?? 'مدرستي' }}</div>
                <small>{{ $setting->address ?? '' }}</small>
            </div>
            @if($setting->logo && file_exists(public_path($setting->logo)))
                <img src="{{ public_path($setting->logo) }}" class="logo" alt="شعار">
            @endif
            <div style="text-align:left">
                <div>الفصل: {{ $classroom->Name_Class }}</div>
                <div>العام الدراسي: {{ date('Y') }}</div>
            </div>
        </div>

        <div class="title">كشف النتائج النهائية</div>

        <table>
            <thead>
                <tr>
                    <th class="row-num">م</th>
                    <th>اسم الطالب</th>
                    <th>القسم</th>
                    @foreach($allSubjects as $subject)
                        <th style="writing-mode:vertical-lr;font-size:9px;">{{ $subject->getTranslation('name', 'ar') }}</th>
                    @endforeach
                    <th>المجموع</th>
                    <th>المعدل</th>
                    <th>التقدير</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $idx => $student)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $student->getTranslation('name', 'ar') }}</td>
                    <td>{{ $student->section ? $student->section->getTranslation('Name_Section', 'ar') : '-' }}</td>
                    @foreach($allSubjects as $subject)
                        <td>
                            {{ $student->degrees->where('quizze_id', $subject->id)->first()->degree ?? '-' }}
                        </td>
                    @endforeach
                    <td>{{ $student->total_score }}</td>
                    <td>{{ $student->avg_score }}</td>
                    <td class="{{ $student->avg_score >= 90 ? 'grade-excellent' : ($student->avg_score >= 80 ? 'grade-very-good' : ($student->avg_score >= 70 ? 'grade-good' : ($student->avg_score >= 60 ? 'grade-pass' : 'grade-fail'))) }}">
                        {{ $student->grade_label }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <div class="sig"><div class="line"></div>رائد المادة</div>
            <div class="sig"><div class="line"></div>مدير المدرسة</div>
        </div>
    </div>
</body>
</html>