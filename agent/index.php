<?php
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
    <p>Hello big 🍆 <strong><?php  echo $_SESSION['name'] ?></strong>. Here you go</p>
    <pre>
        id: <?php  echo $_SESSION['id'] ?>,
        name: <?php  echo $_SESSION['name'] ?>,
        role: <?php  echo $_SESSION['role'] ?>,
        session expires on: <?php  echo date('m/d/Y H:i:s', $_SESSION['expires_at']) ." (". date("H:i:s",$_SESSION['expires_at'] - time())  ." left)"; ?>

    </pre>

    <a href="/moha/src/logout.php">Logout</a>
</body>

</html>