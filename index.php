<?php require_once 'includes/auth.php';
is_logged_in() ? redirect('dashboard.php') : redirect('login.php');
