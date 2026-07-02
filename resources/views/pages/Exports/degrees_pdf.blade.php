<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ public_path('') }}fonts/DejaVuSans.ttf');
        }
        * {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            direction: rtl;
            font-size: 10px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #1a5276;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header h1 {
            font-size: 18px;
            color: #1a5276;
            margin-bottom: 3px;
        }
        .header h2 {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 3px;
        }
        .header .date {
            font-size: 10px;
            color: #7f8c8d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        thead th {
            background-color: #1a5276;
            color: white;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }
        tbody td {
            padding: 5px 4px;
            text-align: center;
            border: 1px solid #bdc3c7;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f3f4;
        }

        .total-cell {
            background-color: #d5f5e3;
            font-weight: bold;
        }
        .percentage-cell {
            font-weight: bold;
        }
        .pass {
            color: #27ae60;
        }
        .fail {
            color: #e74c3c;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #95a5a6;
            border-top: 1px solid #bdc3c7;
            padding: 4px 0;
        }

        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
        }
        .signature-box {
            text-align: center;
            width: 180px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 30px;
            padding-top: 4px;
            font-size: 10px;
        }

        .grade-legend {
            margin-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>
<body>

    <!-- رأس الصفحة -->
    <div class="header">
        <h1>{{ $schoolName }}</h1>
        <h2>كشف نتائج طلاب الصف: {{ $classroom->Name_Class }}</h2>
        <p class="date">التاريخ: {{ $currentDate }}</p>
    </div>

    @if($quizzes->count() > 0)

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">م</th>
                <th style="width: 5%;">رقم الجلوس</th>
                <th style="width: 20%;">اسم الطالب</th>
                <th style="width: 8%;">القسم</th>
                @foreach($quizzes as $quiz)
                    <th style="width: 8%;">
                        {{ $quiz->subject->Name_Subject ?? 'مادة' }}
                        <br>
                        <small>({{ $totalScores[$quiz->id] ?? 0 }})</small>
                    </th>
                @endforeach
                <th style="width: 8%;">المجموع</th>
                <th style="width: 8%;">النسبة</th>
                <th style="width: 6%;">التقدير</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->seat_number ?? ($index + 1) }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->section ? $student->section->Name_Section : '-' }}</td>
                @foreach($quizzes as $quiz)
                    <td>{{ $degreesData[$student->id][$quiz->id] ?? 0 }}</td>
                @endforeach
                <td class="total-cell">{{ $student->totalDegree }}</td>
                <td class="percentage-cell {{ $student->percentage >= 50 ? 'pass' : 'fail' }}">
                    {{ $student->percentage }}%
                </td>
                <td>{{ $student->grade_label ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="grade-legend">
        <strong>دليل التقديرات:</strong>
        ممتاز (90-100) | جيد جداً (80-89) | جيد (70-79) | مقبول (50-69) | راسب (أقل من 50)
    </div>

    @else

    <div style="text-align: center; padding: 40px; color: #e74c3c; font-size: 16px;">
        لا توجد اختبارات مسجلة لهذا الصف بعد
    </div>

    @endif

    <!-- التوقيعات -->
    <div class="signature">
        <div class="signature-box">
            <div class="signature-line">مدير المدرسة</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">المشرف التربوي</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">مدير التعليم</div>
        </div>
    </div>

    <!-- تذييل -->
    <div class="footer">
        <span>{{ $schoolName }} - </span>
        <span>صفحة </span>
        <span>{PAGENO}/{nbpg}</span>
    </div>

</body>
</html>