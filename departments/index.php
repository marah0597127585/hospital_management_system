<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
require_once '../includes/header.php';
$rows = $pdo->query('SELECT * FROM departments ORDER BY id DESC')->fetchAll(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>الأقسام</h2><a class="btn btn-primary" href="create.php">إضافة</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>اسم القسم</th>
            <th>الوصف</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    <tbody><?php foreach ($rows as $r): ?><tr>
                <td><?= e($r['id']) ?></td>
                <td><?= e($r['name']) ?></td>
                <td><?= e($r['description']) ?></td>
                <td><a class="btn btn-sm btn-warning" href="edit.php?id=<?= e($r['id']) ?>">تعديل</a>
                    <form class="delete-form d-inline" method="post" action="delete.php"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn btn-sm btn-danger">حذف</button></form>
                </td>
            </tr><?php endforeach; ?></tbody>
</table><?php require_once '../includes/footer.php'; ?>