<?php 
    include_once "../config.php";
    include_once "../src/needs_auth.php";

    $stmt = $pdo->prepare("SELECT * FROM user where id=:id");
    $stmt->execute([
        'id'=>$user_id,
    ]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <a href="/moha/customer/">Back</a>

    <p>id : <?php echo $customer['id'] ?></p>
    <p>name : <?php echo $customer['name'] ?></p>
    <p>phone number : <?php echo $customer['phone_number'] ?></p>
    <a href="/moha/customer/edit-profile.php">Edit profile</a>
    <a href="/moha/customer/change-password.php">Change password</a>
    <a href="/moha/customer/delete-account.php">Delete account</a>
</body>

</html>