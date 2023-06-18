<?php
session_start();
if (empty($_SESSION['id'])) header("location:/moha/login.php");
else if (time() > $_SESSION['expires_at']) header("location:/moha/src/logout.php");
else if (strtolower(explode('/', $_SERVER['REQUEST_URI'])[2]) !== strtolower($_SESSION['role'])) header("location:/moha/{$_SESSION['role']}/index.php");
else {
    $user_id = $_SESSION['id'];
    $user_name = $_SESSION['name'];
    $user_role = $_SESSION['role'];
    $user_state = $_SESSION['state'];
    $user_session_expires_at = $_SESSION['expires_at'];
    $user_cart = $_SESSION['cart'];
}
