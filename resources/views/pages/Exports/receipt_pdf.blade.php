<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        * { font-family: 'Cairo', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { direction: rtl; color: #333; font-size: 14px; }
        .receipt-container { max-width: 700px; margin: 0 auto; padding: 20px; border: 2px solid #1a73e8; }
        .header { text-align: center; border-bottom: 2px dashed #1a73e8; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #1a73e8; font-size: 24px; }
        .logo { width: 70px; height: 70px; }
        .receipt-title { text-align: center; font-size: 18px; color: #d32f2f; font-weight: bold; margin: 15px 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 10px 12px; border: 1px solid #ddd; }
        .info-table td:first-child { background: #f5f5f5; font-weight: bold; width: 40%; }
        .amount-box { text-align: center; background: #e8f5e9; padding: 15px; border-radius: 8px; border: 2px solid #4caf50; margin: 20px 0; }
        .amount-box .label { font-size: 14px; color: #666; }
        .amount-box .amount { font-size: 32px; color: #2e7d32; font-weight: bold; }
        .footer { display: flex; justify-content: space-around; margin-top: 50px; padding-top: 15px; }
        .sig { text-align: center; }
        .sig .line { border-top: 1px solid #333; width: 120px; margin: 30px auto 5px; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            @if($setting->logo && file_exists(public_path($setting->logo)))
                <img src="{{ public_path($setting->logo) }}" class="logo" alt="شعار">
            @endif
            <h1>{{ $setting->school_name ?? 'مدرستي' }}</h1>
            <p>{{ $setting->phone ?? '' }} - {{ $setting->address ?? '' }}</p>
        </div>

        <div class="receipt-title">سند قبض</div>

        <table class="info-table">
            <tr><td>رقم السند</td><td>{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
            <tr><td>التاريخ</td><td>{{ $receipt->date ? $receipt->date->format('Y-m-d') : now()->format('Y-m-d') }}</td></tr>
            <tr><td>اسم الطالب</td><td>{{ $student->getTranslation('name', 'ar') }}</td></tr>
            <tr><td>الوصف</td><td>{{ $receipt->description ?? '-' }}</td></tr>
        </table>

        <div class="amount-box">
            <div class="label">المبلغ المحصل</div>
            <div class="amount">{{ number_format($receipt->debit ?? 0, 2) }} ريال</div>
        </div>

        <div class="footer">
            <div class="sig"><div class="line"></div>الامين المالي</div>
            <div class="sig"><div class="line"></div>مدير المدرسة</div>
            <div class="sig"><div class="line"></div>ولي الأمر</div>
        </div>
    </div>
</body>
</html>