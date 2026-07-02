<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        * { font-family: 'Cairo', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { direction: rtl; color: #333; font-size: 14px; }
        .invoice-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #1a73e8; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { width: 80px; height: 80px; object-fit: contain; }
        .school-info h1 { color: #1a73e8; font-size: 22px; }
        .school-info p { color: #666; font-size: 12px; }
        .invoice-title { text-align: center; font-size: 20px; color: #1a73e8; font-weight: bold; margin: 20px 0; border: 2px solid #1a73e8; padding: 8px; border-radius: 8px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px 12px; border: 1px solid #ddd; }
        .info-table td:first-child { background: #f8f9fa; font-weight: bold; width: 35%; }
        .amount-box { text-align: center; background: #e8f0fe; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .amount-box .amount { font-size: 28px; color: #1a73e8; font-weight: bold; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; border-top: 1px solid #ddd; padding-top: 15px; }
        .signature-box { text-align: center; min-width: 200px; }
        .signature-line { border-top: 1px solid #333; width: 150px; margin: 40px auto 5px; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="school-info">
                <h1>{{ $setting->school_name ?? 'مدرستي' }}</h1>
                <p>{{ $setting->address ?? '' }}</p>
                <p>{{ $setting->phone ?? '' }}</p>
            </div>
            @if($setting->logo && file_exists(public_path($setting->logo)))
                <img src="{{ public_path($setting->logo) }}" class="logo" alt="شعار المدرسة">
            @endif
        </div>

        <div class="invoice-title">فاتورة رسوم دراسية</div>

        <table class="info-table">
            <tr><td>رقم الفاتورة</td><td>{{ $invoice->id }}</td></tr>
            <tr><td>التاريخ</td><td>{{ $invoice->date ? $invoice->date->format('Y-m-d') : '-' }}</td></tr>
            <tr><td>اسم الطالب</td><td>{{ $student->getTranslation('name', 'ar') }}</td></tr>
            <tr><td>المرحلة</td><td>{{ $student->grade ? $student->grade->getTranslation('Name_Grade', 'ar') : '-' }}</td></tr>
            <tr><td>الفصل</td><td>{{ $student->classroom ? $student->classroom->Name_Class : '-' }}</td></tr>
            <tr><td>نوع الرسوم</td><td>{{ $fee->getTranslation('title', 'ar') }}</td></tr>
            <tr><td>المبلغ</td><td>{{ number_format($invoice->amount, 2) }} ريال</td></tr>
            @if($invoice->discount)
            <tr><td>الخصم</td><td>{{ number_format($invoice->discount, 2) }} ريال</td></tr>
            @endif
            <tr><td>الحالة</td><td>{{ $invoice->invoice_status == 1 ? 'مدفوعة' : 'غير مدفوعة' }}</td></tr>
        </table>

        <div class="amount-box">
            <div>المبلغ الإجمالي</div>
            <div class="amount">{{ number_format($invoice->amount - ($invoice->discount ?? 0), 2) }} ريال</div>
        </div>

        <div class="footer">
            <div class="signature-box">
                <div class="signature-line"></div>
                <span>الإدارة المالية</span>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <span>مدير المدرسة</span>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <span>ولي الأمر</span>
            </div>
        </div>
    </div>
</body>
</html>