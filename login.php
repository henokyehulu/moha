<?php 

require_once "config.php";

session_start();
$now = time();

if(!empty($_SESSION['id'])){
    if($now > $_SESSION['expires_at']) header("location:/auth/src/logout.php");
    else header("location:/auth/{$_SESSION['role']}/index.php");
}

if(isset($_POST['login'])){
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    try {
        $stmt =$pdo->prepare("SELECT * FROM user WHERE phone_number=:phone_number AND password=:password"); 
        $stmt->execute([
            'phone_number'=>$phone_number,
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

            switch (strtolower($role['name'])) {
                case "admin":
                    header("location:/auth/admin/index.php");
                    break;

                case "customer":
                    header("location:/auth/customer/index.php");
                    break;

                case "agent":
                    header("location:/auth/agent/index.php");
                    break;
                
                default:
                    echo "Error occured trying to log you in.";
                    session_destroy();
                    break;
            }
        }else{
            echo "Invalid phone number or password.";
        }
    } catch (PDOException $e) {
        $server_response= $e->getMessage();
        echo $e->getMessage();
        
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
    <form method="post">
        <input type="text" id="phone_number" name="phone_number" placeholder="Phone number" />
        <input type="password" id="password" name="password" placeholder="Password" />
        <button id="login" name="login" type="submit">Login</button>
    </form>
    <a href="/auth/register/customer.php">Create a customer account</a>
    <br>
    <a href="/auth/register/agent.php">Sign up to drive & deliver(agent)</a>
</body>

</html>