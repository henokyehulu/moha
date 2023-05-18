<?php
require_once "../config.php";
require_once "../src/needs_auth.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <p>Hello big 🍆 <strong><?php  echo $user_name?></strong>.</p>
    <a href="/moha/customer/order.php">Order</a>
    <a href="/moha/customer/my-orders.php">My orders</a>
    <a href="/moha/customer/profile.php">Profile</a>
    <a href="/moha/src/logout.php">Logout</a>
</body>

</html>