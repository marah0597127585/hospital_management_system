<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
require_once '../includes/header.php';
$rows = $pdo->query('SELECT doctors.*, departments.name department FROM doctors LEFT JOIN departments ON doctors.department_id=departments.id ORDER BY doctors.id DESC')->fetchAll(); ?>
<div class="d-flex justify-content-between mb-3">
    <h2>الأطباء</h2><a class="btn btn-primary" href="create.php">إضافة طبيب</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>التخصص</th>
            <th>الهاتف</th>
            <th>القسم</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    <tbody><?php foreach ($rows as $r): ?><tr>
                <td><?= e($r['id']) ?></td>
                <td><?= e($r['name']) ?></td>
                <td><?= e($r['specialization']) ?></td>
                <td><?= e($r['phone']) ?></td>
                <td><?= e($r['department']) ?></td>
                <td><a class="btn btn-sm btn-warning" href="edit.php?id=<?= e($r['id']) ?>">تعديل</a>
                    <form class="delete-form d-inline" method="post" action="delete.php"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn btn-sm btn-danger">حذف</button></form>
                </td>
            </tr><?php endforeach; ?></tbody>
</table><?php require_once '../includes/footer.php'; ?>