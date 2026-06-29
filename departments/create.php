<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
check_csrf();
$item = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'description'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $st = $pdo->prepare('INSERT INTO departments(name,description) VALUES(?,?)');
        $st->execute([$_POST['name'], $_POST['description']]);
        flash('success', 'تمت الإضافة بنجاح');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>إضافة - الأقسام</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">اسم القسم</label><input type="text" name="name" value="<?= e($item['name'] ?? '') ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الوصف</label><textarea name="description" class="form-control" required><?= e($item['description'] ?? '') ?></textarea></div><button class="btn btn-primary">حفظ</button>
</form><?php require_once '../includes/footer.php'; ?>