<?php require_once 'config/db.php';
require_once 'includes/functions.php';
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['name', 'email', 'password'])) flash('danger', 'يرجى تعبئة كل الحقول');
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) flash('danger', 'البريد غير صحيح');
    elseif (strlen($_POST['password']) < 6) flash('danger', 'كلمة المرور 6 أحرف على الأقل');
    else {
        try {
            $st = $pdo->prepare('INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)');
            $st->execute([trim($_POST['name']), trim($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT), 'receptionist']);
            flash('success', 'تم إنشاء الحساب. يمكنك الدخول الآن');
            redirect('login.php');
        } catch (PDOException $e) {
            flash('danger', 'البريد مستخدم مسبقاً');
        }
    }
}
require_once 'includes/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3>تسجيل مستخدم جديد</h3>
                <form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                    <div class="mb-3"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">البريد</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">كلمة المرور</label><input type="password" name="password" class="form-control" required></div><button class="btn btn-primary w-100">تسجيل</button>
                </form>
            </div>
        </div>
    </div>
</div><?php require_once 'includes/footer.php'; ?>