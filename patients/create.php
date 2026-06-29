<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
check_csrf();
$item = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'phone', 'gender', 'birth_date', 'address'])) flash('danger', 'يرجى تعبئة الحقول');
    else {
        $st = $pdo->prepare('INSERT INTO patients(name,phone,gender,birth_date,address) VALUES(?,?,?,?,?)');
        $st->execute([$_POST['name'], $_POST['phone'], $_POST['gender'], $_POST['birth_date'], $_POST['address']]);
        flash('success', 'تمت الإضافة بنجاح');
        redirect('index.php');
    }
}
require_once '../includes/header.php'; ?>
<h2>إضافة - المرضى</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">الاسم</label><input type="text" name="name" value="<?= e($item['name'] ?? '') ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الهاتف</label><input type="text" name="phone" value="<?= e($item['phone'] ?? '') ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الجنس</label><select name="gender" class="form-select">
            <option value="ذكر" <?= (($item['gender'] ?? '') == 'ذكر') ? 'selected' : '' ?>>ذكر</option>
            <option value="أنثى" <?= (($item['gender'] ?? '') == 'أنثى') ? 'selected' : '' ?>>أنثى</option>
        </select></div>
    <div class="mb-3"><label class="form-label">تاريخ الميلاد</label><input type="date" name="birth_date" value="<?= e($item['birth_date'] ?? '') ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">العنوان</label><textarea name="address" class="form-control" required><?= e($item['address'] ?? '') ?></textarea></div><button class="btn btn-primary">حفظ</button>
</form><?php require_once '../includes/footer.php'; ?>