<?php
session_start();
session_destroy();
header("location:/moha/index.php");
?>