<?php
if (session_status() === PHP_SESSION_NONE) session_start();
function e($v)
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
function redirect($url)
{
    header("Location: $url");
    exit;
}
function flash($type, $msg)
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}
function show_flash()
{
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        echo '<div class="alert alert-' . e($f['type']) . ' alert-dismissible fade show">' . e($f['msg']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        unset($_SESSION['flash']);
    }
}
function csrf_token()
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function check_csrf()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']))) die('Invalid CSRF token');
}
function required($arr, $fields)
{
    foreach ($fields as $f) {
        if (!isset($arr[$f]) || trim($arr[$f]) === '') return false;
    }
    return true;
}
