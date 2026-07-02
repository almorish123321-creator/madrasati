<?php

namespace App\Exports;

use App\Models\Fee_invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FeesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function collection()
    {
        return Fee_invoice::with(['student', 'fee', 'grade'])->get();
    }

    public function headings(): array
    {
        return ['رقم الفاتورة', 'الطالب', 'الرسوم', 'المبلغ', 'الخصم', 'المبلغ الإجمالي', 'الحالة', 'التاريخ'];
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->student ? $invoice->student->getTranslation('name', 'ar') : '',
            $invoice->fee ? $invoice->fee->getTranslation('title', 'ar') : '',
            $invoice->amount,
            $invoice->discount ?? 0,
            $invoice->amount - ($invoice->discount ?? 0),
            $invoice->invoice_status == 1 ? 'مدفوعة' : 'غير مدفوعة',
            $invoice->date ? $invoice->date->format('Y-m-d') : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }

    public function title(): string
    {
        return 'الفواتير والرسوم';
    }
}