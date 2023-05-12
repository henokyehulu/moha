<?php 

require_once "../config.php";

session_start();
$now = time();

if(!empty($_SESSION['id'])){
    if($now > $_SESSION['expires_at']) header("location:/auth/src/logout.php");
    else header("location:/auth/{$_SESSION['role']}/index.php");
}

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $role_name = "customer";

    $stmt =$pdo->prepare("SELECT id FROM role WHERE name=:role"); 
    $stmt->execute([
        'role'=>$role_name,
    ]);
    $role = $stmt->fetch(PDO::FETCH_ASSOC);
    try {
        $stmt =$pdo->prepare("SELECT * FROM user WHERE phone_number=:phone_number"); 
        $stmt->execute([
            'phone_number'=>$phone_number,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($stmt->rowCount() === 0) {
            $stmt =$pdo->prepare("INSERT INTO user (name, phone_number, password, role) VALUES(:name, :phone_number, :password, :role)"); 
            $stmt->execute([
                'name'=>$name,
                'phone_number'=>$phone_number,
                'password'=>$password,
                'role'=> $role['id'],
            ]);

            $_SESSION['id'] = $pdo->lastInsertId();
            $_SESSION['name'] = $name;
            $_SESSION['role'] = "customer";
            $_SESSION['expires_at'] = time() + 24 * 60 * 60;
            header("location:/auth/customer/index.php");
        } else {
            echo "Phone number is already registered with another user.";
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
    <title>Register customer</title>
</head>

<body>
    <form method="post">
        <input type="text" id="name" name="name" placeholder="Full name" />
        <input type="text" id="phone_number" name="phone_number" placeholder="Phone number" />
        <input type="password" id="password" name="password" placeholder="Password" />
        <button id="register" name="register" type="submit">Register</button>
    </form>
</body>

</html>