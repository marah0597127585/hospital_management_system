<?php require_once '../config/db.php';
require_once '../includes/auth.php';
require_login();
check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st = $pdo->prepare('DELETE FROM departments WHERE id=?');
    $st->execute([(int)$_POST['id']]);
    flash('success', 'تم الحذف');
}
redirect('index.php');
