<?php require_once 'config/db.php';
require_once 'includes/functions.php';
if (isset($_COOKIE['remember_email'])) $remember = $_COOKIE['remember_email'];
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!required($_POST, ['email', 'password'])) flash('danger', 'يرجى تعبئة كل الحقول');
    else {
        $st = $pdo->prepare('SELECT * FROM users WHERE email=?');
        $st->execute([trim($_POST['email'])]);
        $u = $st->fetch();
        if ($u && password_verify($_POST['password'], $u['password'])) {
            $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name'], 'email' => $u['email'], 'role' => $u['role']];
            if (isset($_POST['remember'])) setcookie('remember_email', $u['email'], time() + 86400 * 30, '/');
            redirect('dashboard.php');
        } else flash('danger', 'بيانات الدخول غير صحيحة');
    }
}
require_once 'includes/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">تسجيل الدخول</h3>
                <form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                    <div class="mb-3"><label class="form-label">البريد الإلكتروني</label><input type="email" name="email" class="form-control" value="<?= e($remember ?? '') ?>" required></div>
                    <div class="mb-3"><label class="form-label">كلمة المرور</label><input type="password" name="password" class="form-control" required></div>
                    <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="r"><label class="form-check-label" for="r">تذكر البريد</label></div><button class="btn btn-primary w-100">دخول</button>
                </form>
                <p class="mt-3">ليس لديك حساب؟ <a href="register.php">سجل الآن</a></p>
            </div>
        </div>
    </div>
</div><?php require_once 'includes/footer.php'; ?>