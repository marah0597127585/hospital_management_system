<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_role('admin');
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (int)$_POST['id'] !== current_user()['id']) {
    $pdo->prepare('DELETE FROM users WHERE id=?')->execute([(int)$_POST['id']]);
    flash('success', 'تم الحذف');
}
redirect('index.php');
