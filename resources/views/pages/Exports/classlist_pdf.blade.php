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
            font-size: 12px;
            color: #333;
        }

        /* رأس الصفحة */
        .header {
            text-align: center;
            border-bottom: 3px double #1a5276;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            color: #1a5276;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header .date {
            font-size: 11px;
            color: #7f8c8d;
        }

        /* الجدول */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead th {
            background-color: #1a5276;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
        }
        tbody td {
            padding: 8px;
            text-align: center;
            border: 1px solid #bdc3c7;
            font-size: 12px;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f3f4;
        }
        tbody tr:hover {
            background-color: #d5f5e3;
        }

        /* تذييل الصفحة */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #95a5a6;
            border-top: 1px solid #bdc3c7;
            padding: 5px 0;
        }
        .footer .page-number {
            font-weight: bold;
        }

        /* التوقيع */
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <!-- رأس الصفحة -->
    <div class="header">
        <h1>{{ $schoolName }}</h1>
        <h2>كشف أسماء طلاب الصف: {{ $classroom->Name_Class }}</h2>
        <p class="date">التاريخ: {{ $currentDate }}</p>
    </div>

    <!-- جدول الطلاب -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">م</th>
                <th style="width: 12%;">رقم الجلوس</th>
                <th style="width: 35%;">اسم الطالب</th>
                <th style="width: 15%;">القسم</th>
                <th style="width: 15%;">الجنس</th>
                <th style="width: 15%;">رقم الهوية</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->display_seat }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->section ? $student->section->Name_Section : '-' }}</td>
                <td>{{ $student->gender ? $student->gender->Name : '-' }}</td>
                <td>-</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 15px; text-align: center; font-weight: bold;">
        إجمالي عدد الطلاب: {{ $students->count() }}
    </p>

    <!-- التوقيعات -->
    <div class="signature">
        <div class="signature-box">
            <div class="signature-line">مدير المدرسة</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">المرشد الطلابي</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">مدير الإدارة</div>
        </div>
    </div>

    <!-- تذييل -->
    <div class="footer">
        <span>{{ $schoolName }} - </span>
        <span>صفحة رقم </span>
        <span class="page-number">{PAGENO}</span>
        <span> من </span>
        <span class="page-number">{nbpg}</span>
    </div>

</body>
</html>