<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare('SELECT * FROM departments WHERE id=?');
$st->execute([$id]);
$item = $st->fetch();
if (!$item) die('Not found');
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'description'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $st = $pdo->prepare('UPDATE departments SET name=?,description=? WHERE id=?');
        $st->execute([$_POST['name'], $_POST['description'], $id]);
        flash('success', 'تم التعديل بنجاح');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>تعديل - الأقسام</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">اسم القسم</label><input type="text" name="name" value="<?= e($item['name'] ?? '') ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الوصف</label><textarea name="description" class="form-control" required><?= e($item['description'] ?? '') ?></textarea></div><button class="btn btn-primary">تحديث</button>
</form><?php require_once '../includes/footer.php'; ?>