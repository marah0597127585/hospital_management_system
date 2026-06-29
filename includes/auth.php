<?php
require_once __DIR__ . '/functions.php';
function is_logged_in()
{
    return isset($_SESSION['user']);
}
function current_user()
{
    return $_SESSION['user'] ?? null;
}
function require_login()
{
    if (!is_logged_in()) redirect('/hospital_management_system/login.php');
}
function require_role($roles)
{
    require_login();
    $roles = (array)$roles;
    if (!in_array($_SESSION['user']['role'], $roles, true)) {
        http_response_code(403);
        die('Access denied');
    }
}
