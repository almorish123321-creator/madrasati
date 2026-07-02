<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            direction: rtl;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h2 {
            font-size: 16px;
            color: #1a5276;
        }
        .header h3 {
            font-size: 13px;
            color: #2c3e50;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        thead th {
            background-color: #1a5276;
            color: white;
            padding: 6px 3px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #154360;
        }
        tbody td {
            padding: 5px 3px;
            text-align: center;
            border: 1px solid #bdc3c7;
        }
        tbody tr:nth-child(even) {
            background-color: #eaf2f8;
        }

        .present {
            color: #27ae60;
            font-weight: bold;
        }
        .absent {
            color: #e74c3c;
            font-weight: bold;
        }
        .weekend {
            background-color: #f9e79f !important;
            color: #7d6608;
            text-align: center;
            font-size: 9px;
        }

        .summary {
            margin-top: 15px;
            display: flex;
            justify-content: space-around;
            font-size: 12px;
        }
        .summary-box {
            text-align: center;
            padding: 8px 15px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }
        .summary-box .number {
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>سجل الحضور والغياب</h2>
        <h3>الصف: {{ $classroom->Name_Class }} | {{ $monthName }} {{ $year }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">م</th>
                <th style="width: 8%;">رقم الجلوس</th>
                <th style="width: 20%;">اسم الطالب</th>
                <th style="width: 7%;">القسم</th>
                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $dayOfWeek = date('N', strtotime($dateStr));
                        $isWeekend = in_array($dayOfWeek, [5, 6]); // الجمعة والسبت
                    @endphp
                    <th style="width: 2%; font-size: 9px;"
                        class="{{ $isWeekend ? 'weekend' : '' }}">
                        {{ $day }}
                        <br>
                        <small>{{ ['','إث','ثل','أر','خم','جم','سب','أح'][$dayOfWeek] ?? '' }}</small>
                    </th>
                @endfor
                <th style="width: 5%;">حاضر</th>
                <th style="width: 5%;">غائب</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            @php
                $studentAttendance = $attendances->get($student->id);
                $presentCount = 0;
                $absentCount = 0;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->seat_number ?? ($index + 1) }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->section ? $student->section->Name_Section : '-' }}</td>
                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $dayOfWeek = date('N', strtotime($dateStr));
                        $isWeekend = in_array($dayOfWeek, [5, 6]);
                    @endphp
                    @if($isWeekend)
                        <td class="weekend">-</td>
                    @else
                        @php
                            $dayAttendance = null;
                            if ($studentAttendance) {
                                foreach ($studentAttendance as $att) {
                                    if ($att->attendence_date == $dateStr) {
                                        $dayAttendance = $att;
                                        break;
                                    }
                                }
                            }
                        @endphp
                        @if($dayAttendance)
                            @if($dayAttendance->attendence_status)
                                @php $presentCount++; @endphp
                                <td class="present">ح</td>
                            @else
                                @php $absentCount++; @endphp
                                <td class="absent">غ</td>
                            @endif
                        @else
                            <td></td>
                        @endif
                    @endif
                @endfor
                <td style="background-color: #d5f5e3; font-weight: bold;">{{ $presentCount }}</td>
                <td style="background-color: #fadbd8; font-weight: bold;">{{ $absentCount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>تم إنشاء هذا التقرير بتاريخ: {{ date('Y/m/d H:i') }}</p>
        <p>نظام إدارة مدرستي</p>
    </div>

</body>
</html>