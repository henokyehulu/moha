<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT * FROM user where id=?");
$stmt->execute([$user_id]);
$agent = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <a href="/moha/agent/">Back</a>

    <p>id : <?php echo $agent['id'] ?></p>
    <p>name : <?php echo $agent['name'] ?></p>
    <p>phone number : <?php echo $agent['phone_number'] ?></p>
    <p>TIN : <?php echo $agent['tin'] ?? "none" ?></p>
    <a href="/moha/agent/edit-profile.php">Edit profile</a>
    <a href="/moha/agent/change-password.php">Change password</a>
    <a href="/moha/agent/delete-account.php">Delete account</a>
</body>

</html>