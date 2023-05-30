<?php
session_start();
session_destroy();
header("location:/moha/login.php");
