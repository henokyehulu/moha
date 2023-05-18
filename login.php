<?php 

require_once "config.php";
require_once "./src/validate_phone_number.php";

session_start();
$now = time();

if(!empty($_SESSION['id'])){
    if($now > $_SESSION['expires_at']) header("location:/moha/src/logout.php");
    else header("location:/moha/{$_SESSION['role']}/index.php");
}

$phone_number = $_POST['phone_number'] ?? "";
$password = $_POST['password'] ?? "";
if(isset($_POST['login'])){

    if(validate_phone_number($phone_number) == null){
        $server_response = "Invalid phone number";
    }
    if(empty($server_response)){

        try {
        $stmt =$pdo->prepare("SELECT * FROM user WHERE phone_number=:phone_number AND password=:password"); 
        $stmt->execute([
            'phone_number'=>validate_phone_number($phone_number),
            'password'=>$password
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() > 0){
            $stmt =$pdo->prepare("SELECT role.name FROM user INNER JOIN role ON {$row['role']}=role.id"); 
            $stmt->execute();
            $role = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $role['name'];
            $_SESSION['expires_at'] = time() + 24 * 60 * 60;
            $_SESSION['cart'] = [];

            switch (strtolower($role['name'])) {
                case "admin":
                    header("location:/moha/admin/index.php");
                    break;

                case "customer":
                    header("location:/moha/customer/index.php");
                    break;

                case "agent":
                    header("location:/moha/agent/index.php");
                    break;
                
                default:
                    $server_response= "Error occured trying to log you in.";
                    session_destroy();
                    break;
            }
        }else{
            $server_response= "Invalid phone number or password.";
        }
    } catch (PDOException $e) {
        $server_response= $e->getMessage();
        
    }
}

}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <?php
            if(!empty($server_response)){?>
    <p><?php echo $server_response ?></p>
    <?php } ?>
    <form method="post">
        <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number;?>"
            placeholder="Phone number" />
        <input type="password" id="password" name="password" placeholder="Password" />
        <button id="login" name="login" type="submit">Login</button>
    </form>
    <a href="/moha/register/customer.php">Create a customer account</a>
    <br>
    <a href="/moha/register/agent.php">Sign up to drive & deliver(agent)</a>
</body>

</html>