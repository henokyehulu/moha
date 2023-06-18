<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$server_error = [];

if (isset($_POST['delete_account'])) {

    $stmt = $pdo->prepare("SELECT password FROM user where id=?");
    $stmt->execute([$user_id,]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user['password'] === $_POST['password']) {
        $stmt = $pdo->prepare("DELETE FROM user where id=?");
        $stmt->execute([$user_id]);
        $server_error = [];
        echo "<script>
            window.location.href='/moha/src/logout.php';
            alert('Account deleted successfully!');
            </script>";
    } else {
        $server_error[] = "Password is invalid.";
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete account</title>
</head>

<body>
    <a href="/moha/agent/profile.php">Back</a>
    <ul>
        <?php
        foreach ($server_error as $error) { ?>
            <li style="color: red;"><?php echo $error ?></li>
        <?php } ?>
    </ul>
    <?php ?>
    <form method="post">
        <input type="password" name="password" placeholder="Password" required />
        <button name="delete_account" type="submit">Delete account</button>
    </form>
</body>

</html>