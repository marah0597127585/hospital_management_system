<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare('SELECT * FROM doctors WHERE id=?');
$st->execute([$id]);
$item = $st->fetch();
if (!$item) die('Not found');
$deps = $pdo->query('SELECT * FROM departments ORDER BY name')->fetchAll();
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'specialization', 'phone', 'department_id'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $st = $pdo->prepare('UPDATE doctors SET name=?,specialization=?,phone=?,department_id=? WHERE id=?');
        $st->execute([$_POST['name'], $_POST['specialization'], $_POST['phone'], $_POST['department_id'], $id]);
        flash('success', 'تم التعديل');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>تعديل طبيب</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">الاسم</label><input name="name" value="<?= e($item['name']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">التخصص</label><input name="specialization" value="<?= e($item['specialization']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الهاتف</label><input name="phone" value="<?= e($item['phone']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">القسم</label><select name="department_id" class="form-select" required><?php foreach ($deps as $d): ?><option value="<?= e($d['id']) ?>" <?= ($item['department_id'] == $d['id']) ? 'selected' : '' ?>><?= e($d['name']) ?></option><?php endforeach; ?></select></div><button class="btn btn-primary">تحديث</button>
</form><?php require_once '../includes/footer.php'; ?>