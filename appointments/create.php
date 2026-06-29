<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
$patients = $pdo->query('SELECT * FROM patients ORDER BY name')->fetchAll();
$doctors = $pdo->query('SELECT * FROM doctors ORDER BY name')->fetchAll();
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['patient_id', 'doctor_id', 'appointment_date', 'status'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $st = $pdo->prepare('INSERT INTO appointments(patient_id,doctor_id,appointment_date,status,notes) VALUES(?,?,?,?,?)');
        $st->execute([$_POST['patient_id'], $_POST['doctor_id'], $_POST['appointment_date'], $_POST['status'], $_POST['notes'] ?? '']);
        flash('success', 'تمت الإضافة');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>إضافة موعد</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">المريض</label><select name="patient_id" class="form-select" required><?php foreach ($patients as $p): ?><option value="<?= e($p['id']) ?>"><?= e($p['name']) ?></option><?php endforeach; ?></select></div>
    <div class="mb-3"><label class="form-label">الطبيب</label><select name="doctor_id" class="form-select" required><?php foreach ($doctors as $d): ?><option value="<?= e($d['id']) ?>"><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
    <div class="mb-3"><label class="form-label">التاريخ والوقت</label><input type="datetime-local" name="appointment_date" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الحالة</label><select name="status" class="form-select">
            <option>مجدول</option>
            <option>مكتمل</option>

            <option>ملغي</option>
        </select></div>
    <div class="mb-3"><label class="form-label">ملاحظات</label><textarea name="notes" class="form-control"></textarea></div><button class="btn btn-primary">حفظ</button>
</form><?php require_once '../includes/footer.php'; ?>