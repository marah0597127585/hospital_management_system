<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_role('admin');
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'email', 'password', 'role'])) flash('danger', 'يرجى تعبئة الحقول');
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) flash('danger', 'البريد غير صحيح');
    else {
        try {
            $st = $pdo->prepare('INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)');
            $st->execute([$_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['role']]);
            flash('success', 'تمت الإضافة');
            redirect('index.php');
        } catch (PDOException $e) {
            flash('danger', 'البريد مستخدم');
        }
    }
}
require_once '../includes/header.php'; ?>
<h2>إضافة مستخدم</h2>
<form method="post" class="card card-body"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">البريد</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">كلمة المرور</label><input type="password" name="password" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الصلاحية</label><select name="role" class="form-select">
            <option value="admin">admin</option>
            <option value="doctor">doctor</option>
            <option value="receptionist">receptionist</option>
        </select></div><button class="btn btn-primary">حفظ</button>
</form><?php require_once '../includes/footer.php'; ?>