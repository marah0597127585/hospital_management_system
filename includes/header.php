<?php require_once __DIR__ . '/auth.php'; ?>
<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>نظام إدارة مستشفى</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/hospital_management_system/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/hospital_management_system/dashboard.php">إدارة المستشفى</a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (is_logged_in()): ?>
                        <li class="nav-item"><a class="nav-link" href="/hospital_management_system/dashboard.php">لوحة التحكم</a></li>
                        <li class="nav-item"><a class="nav-link" href="/hospital_management_system/patients/index.php">المرضى</a></li>
                        <li class="nav-item"><a class="nav-link" href="/hospital_management_system/doctors/index.php">الأطباء</a></li>
                        <li class="nav-item"><a class="nav-link" href="/hospital_management_system/departments/index.php">الأقسام</a></li>
                        <li class="nav-item"><a class="nav-link" href="/hospital_management_system/appointments/index.php">المواعيد</a></li>
                        <?php if (current_user()['role'] === 'admin'): ?><li class="nav-item"><a class="nav-link" href="/hospital_management_system/users/index.php">المستخدمون</a></li><?php endif; ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (is_logged_in()): ?><li class="nav-item"><span class="navbar-text text-white me-3"><?= e(current_user()['name']) ?> (<?= e(current_user()['role']) ?>)</span></li>
                        <li class="nav-item"><a class="btn btn-light btn-sm" href="/hospital_management_system/logout.php">خروج</a></li>
                    <?php else: ?><li class="nav-item"><a class="nav-link" href="/hospital_management_system/login.php">دخول</a></li>
                        <li class="nav-item"><a class="nav-link" href="/hospital_management_system/register.php">تسجيل</a></li><?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-4"><?php show_flash(); ?>