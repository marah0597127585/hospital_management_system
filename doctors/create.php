<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
$deps = $pdo->query('SELECT * FROM departments ORDER BY name')->fetchAll();
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'specialization', 'phone', 'department_id'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $st = $pdo->prepare('INSERT INTO doctors(name,specialization,phone,department_id) VALUES(?,?,?,?)');
        $st->execute([$_POST['name'], $_POST['specialization'], $_POST['phone'], $_POST['department_id']]);
        flash('success', 'تمت الإضافة');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>إضافة طبيب</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">التخصص</label><input name="specialization" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الهاتف</label><input name="phone" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">القسم</label><select name="department_id" class="form-select" required><?php foreach ($deps as $d): ?><option value="<?= e($d['id']) ?>"><?= e($d['name']) ?></option><?php endforeach; ?></select></div><button class="btn btn-primary">حفظ</button>
</form><?php require_once '../includes/footer.php'; ?>