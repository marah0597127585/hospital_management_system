# نظام إدارة مستشفى

تطبيق ويب ديناميكي لإدارة مستشفى باستخدام PHP و MySQL و Bootstrap CDN.

## التشغيل
1. انسخ مجلد `hospital_management_system` إلى `htdocs` داخل XAMPP.
2. افتح phpMyAdmin واستورد الملف: `database/hospital_db.sql`.
3. افتح: `http://localhost/hospital_management_system/`.

## بيانات الدخول
- Email: `admin@hospital.com`
- Password: `admin123`

## المتطلبات المنفذة
- Login / Register / Logout.
- Admin Dashboard.
- CRUD كامل: المرضى، الأطباء، الأقسام، المواعيد، المستخدمون.
- Sessions و Cookies.
- Validation.
- Password Hashing.
- حماية من SQL Injection باستخدام PDO Prepared Statements.
- CSRF Token للنماذج.
- صلاحيات: admin / doctor / receptionist.
- Bootstrap كـ CDN link.

## الجداول والعلاقات ERD
- users: إدارة المستخدمين والصلاحيات.
- departments: أقسام المستشفى.
- doctors: كل طبيب يتبع قسماً واحداً.
- patients: بيانات المرضى.
- appointments: يربط المريض بالطبيب.

العلاقات:
- departments 1 -- N doctors
- patients 1 -- N appointments
- doctors 1 -- N appointments
