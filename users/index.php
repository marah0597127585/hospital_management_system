<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_role('admin');
require_once '../includes/header.php';
$rows = $pdo->query('SELECT id,name,email,role,created_at FROM users ORDER BY id DESC')->fetchAll(); ?>
<div class="d-flex justify-content-between mb-3">
    <h2>إدارة المستخدمين</h2><a class="btn btn-primary" href="create.php">إضافة مستخدم</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>البريد</th>
            <th>الصلاحية</th>
            <th>تاريخ الإنشاء</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    <tbody><?php foreach ($rows as $r): ?><tr>
                <td><?= e($r['id']) ?></td>
                <td><?= e($r['name']) ?></td>
                <td><?= e($r['email']) ?></td>
                <td><?= e($r['role']) ?></td>
                <td><?= e($r['created_at']) ?></td>
                <td><a class="btn btn-sm btn-warning" href="edit.php?id=<?= e($r['id']) ?>">تعديل</a><?php if ($r['id'] != current_user()['id']): ?><form class="delete-form d-inline" method="post" action="delete.php"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn btn-sm btn-danger">حذف</button></form><?php endif; ?></td>
            </tr><?php endforeach; ?></tbody>
</table><?php require_once '../includes/footer.php'; ?>