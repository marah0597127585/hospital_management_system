<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_role('admin');
$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare('SELECT * FROM users WHERE id=?');
$st->execute([$id]);
$item = $st->fetch();
if (!$item) die('Not found');
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'email', 'role'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $sql = 'UPDATE users SET name=?,email=?,role=?';
        $params = [$_POST['name'], $_POST['email'], $_POST['role']];
        if (!empty($_POST['password'])) {
            $sql .= ',password=?';
            $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $sql .= ' WHERE id=?';
        $params[] = $id;
        $pdo->prepare($sql)->execute($params);
        flash('success', 'تم التعديل');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>تعديل مستخدم</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">الاسم</label><input name="name" value="<?= e($item['name']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">البريد</label><input type="email" name="email" value="<?= e($item['email']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">كلمة مرور جديدة (اختياري)</label><input type="password" name="password" class="form-control"></div>
    <div class="mb-3"><label class="form-label">الصلاحية</label><select name="role" class="form-select"><?php foreach (['admin', 'doctor', 'receptionist'] as $r): ?><option value="<?= e($r) ?>" <?= ($item['role'] == $r) ? 'selected' : '' ?>><?= e($r) ?></option><?php endforeach; ?></select></div><button class="btn btn-primary">تحديث</button>
</form><?php require_once '../includes/footer.php'; ?>