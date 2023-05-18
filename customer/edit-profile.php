<?php 
    include_once "../config.php";
    include_once "../src/needs_auth.php";
    include_once "../src/validate_phone_number.php";

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
        'name'=>$_POST['name'] ?? $customer['name'],
        'phone_number'=> $_POST['phone_number'] ?? $customer['phone_number'],
        'id'=>$customer['id']
    ];

   

    if(isset($_POST['save'])){
        $phone_number = validate_phone_number($form_data['phone_number']);
        if($phone_number == null){
            $server_error[] = "Invalid phone number";
        }else if($phone_number !== $customer['phone_number']){
            $stmt = $pdo->prepare("SELECT phone_number FROM user WHERE phone_number=:phone_number");
            $stmt->execute([
                'phone_number'=>$phone_number,
            ]);
            
            if($stmt->rowCount() > 0){
                $server_error[] = "Phone number is already in use.";
            }
        }

       
        if(empty($server_error)){   
            $stmt = $pdo->prepare("UPDATE user SET name=:name, phone_number=:phone_number where id=:id");
            $stmt->execute([
                ...$form_data,
            'phone_number'=>$phone_number
        ]);
            $_SESSION['name'] = $form_data['name'];
            $server_error = [];
            echo "<script>
            window.location.href='/moha/customer/profile.php';
            alert('Profile edited successfully!');
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
        <input type="text" name="name" value="<?php echo $form_data['name']?>" placeholder="Full name" required />
        <input type="tel" name="phone_number" value="<?php echo $form_data['phone_number']?>" placeholder="Phone number"
            required />
        <button name="save" type="submit">Save</button>
    </form>
</body>

</html>