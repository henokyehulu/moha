<?php 
    include_once "../config.php";
    include_once "../src/needs_auth.php";

    $server_error = [];

    $stmt = $pdo->prepare("SELECT * FROM user where id=:id");
    $stmt->execute([
        'id'=>$user_id,
    ]);
    
    if($stmt->rowCount() == 0) {
        header("location:/moha/src/logout.php");
        exit;    
    }
    
    $customer = $stmt->fetch(PDO::FETCH_ASSOC); 

    $form_data = [
        'old_password'=>$_POST['old_password'] ?? "",
        'new_password'=> $_POST['new_password'] ?? "",
        'id'=>$customer['id']
    ];

   

    if(isset($_POST['save'])){
            if($customer['password'] !== $form_data['old_password']){
                $server_error [] = "Old password incorrect.";
            }

       
        if(empty($server_error)){   
            $stmt = $pdo->prepare("UPDATE user SET password=:password where id=:id");
            $stmt->execute([
                'password'=>$form_data['new_password'],
                'id'=>$form_data['id']
            ]);
            $server_error = [];
            echo "<script>
            window.location.href='/moha/customer/profile.php';
            alert('Password changed successfully!');
            </script>";
        }
    }
    
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>
</head>

<body>
    <a href="/moha/customer/profile.php">Back</a>
    <ul>
        <?php
    foreach ($server_error as $error) {?>
        <li style="color: red;"><?php echo $error ?></li>
        <?php }?>
    </ul>
    <?php ?>
    <form method="post">
        <input type="password" name="old_password" value="<?php echo $form_data['old_password']?>"
            placeholder="Old password" required />
        <input type="password" name="new_password" value="<?php echo $form_data['new_password']?>"
            placeholder="New password" required />
        <button name="save" type="submit">Save</button>
    </form>
</body>

</html>