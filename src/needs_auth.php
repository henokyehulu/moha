<?php
session_start();
if(empty($_SESSION['id'])) header("location:/auth/login.php");
else if(time() > $_SESSION['expires_at']) header("location:/auth/src/logout.php");
else if (strtolower(explode('/', $_SERVER['REQUEST_URI'])[2]) !== strtolower($_SESSION['role'])) header("location:/auth/{$_SESSION['role']}/index.php");
?>