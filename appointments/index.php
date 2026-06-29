<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
require_once '../includes/header.php';
$rows = $pdo->query('SELECT a.*, p.name patient, d.name doctor FROM appointments a JOIN patients p ON a.patient_id=p.id JOIN doctors d ON a.doctor_id=d.id ORDER BY a.appointment_date DESC')->fetchAll(); ?>
<div class="d-flex justify-content-between mb-3">
    <h2>المواعيد</h2><a class="btn btn-primary" href="create.php">إضافة موعد</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>المريض</th>
            <th>الطبيب</th>
            <th>التاريخ</th>
            <th>الحالة</th>
            <th>ملاحظات</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    <tbody><?php foreach ($rows as $r): ?><tr>
                <td><?= e($r['id']) ?></td>
                <td><?= e($r['patient']) ?></td>
                <td><?= e($r['doctor']) ?></td>
                <td><?= e($r['appointment_date']) ?></td>
                <td><?= e($r['status']) ?></td>
                <td><?= e($r['notes']) ?></td>
                <td><a class="btn btn-sm btn-warning" href="edit.php?id=<?= e($r['id']) ?>">تعديل</a>
                    <form class="delete-form d-inline" method="post" action="delete.php"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn btn-sm btn-danger">حذف</button></form>
                </td>
            </tr><?php endforeach; ?></tbody>
</table><?php require_once '../includes/footer.php'; ?>