---
Task ID: 1
Agent: Main Agent
Task: تطوير نظام إدارة مدرستي - التخصيص + الاستيراد من Excel + التصدير PDF/Excel

Work Log:
- استنساخ المشروع من GitHub ودراسة هيكله بالكامل
- تخصيص النظام: تغيير الاسم في .env.example والترجمات العربية والإنجليزية
- تحديث صفحات login و selection بعنوان النظام الجديد
- إنشاء Migration لإضافة عمود seat_number
- إنشاء StudentsImport class لاستيراد الطلاب من Excel
- إنشاء AttendanceExport class لتصدير الحضور
- إنشاء ExportImportController بكل الوظائف
- إنشاء 5 قوالب Blade (import, attendance_form, classlist_pdf, degrees_pdf, attendance_excel)
- تحديث Routes بـ 7 مسارات جديدة
- تحديث صفحة الطلاب بزر الاستيراد
- تحديث صفحة الصفوف بعمود التقارير و3 أزرار تصدير
- تحديث composer.json بالحزم الجديدة
- كتابة دليل التثبيت الشامل INSTALLATION_GUIDE.txt

Stage Summary:
- 9 ملفات جديدة تم إنشاؤها
- 9 ملفات تم تعديلها
- 7 مسارات Routes جديدة
- 4 ميزات جديدة: استيراد Excel، كشف صف PDF، حضور Excel، نتائج PDF