<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare('SELECT * FROM appointments WHERE id=?');
$st->execute([$id]);
$item = $st->fetch();
if (!$item) die('Not found');
$patients = $pdo->query('SELECT * FROM patients ORDER BY name')->fetchAll();
$doctors = $pdo->query('SELECT * FROM doctors ORDER BY name')->fetchAll();
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['patient_id', 'doctor_id', 'appointment_date', 'status'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $st = $pdo->prepare('UPDATE appointments SET patient_id=?,doctor_id=?,appointment_date=?,status=?,notes=? WHERE id=?');
        $st->execute([$_POST['patient_id'], $_POST['doctor_id'], $_POST['appointment_date'], $_POST['status'], $_POST['notes'] ?? '', $id]);
        flash('success', 'تم التعديل');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>تعديل موعد</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">المريض</label><select name="patient_id" class="form-select" required><?php foreach ($patients as $p): ?><option value="<?= e($p['id']) ?>" <?= ($item['patient_id'] == $p['id']) ? 'selected' : '' ?>><?= e($p['name']) ?></option><?php endforeach; ?></select></div>
    <div class="mb-3"><label class="form-label">الطبيب</label><select name="doctor_id" class="form-select" required><?php foreach ($doctors as $d): ?><option value="<?= e($d['id']) ?>" <?= ($item['doctor_id'] == $d['id']) ? 'selected' : '' ?>><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
    <div class="mb-3"><label class="form-label">التاريخ والوقت</label><input type="datetime-local" name="appointment_date" value="<?= e(str_replace(' ', 'T', $item['appointment_date'])) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الحالة</label><select name="status" class="form-select"><?php foreach (['مجدول', 'مكتمل', 'ملغي'] as $s): ?><option <?= ($item['status'] == $s) ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?></select></div>
    <div class="mb-3"><label class="form-label">ملاحظات</label><textarea name="notes" class="form-control"><?= e($item['notes']) ?></textarea></div><button class="btn btn-primary">تحديث</button>
</form><?php require_once '../includes/footer.php'; ?>