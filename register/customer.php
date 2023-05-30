<?php

require_once "../config.php";
require_once "../src/validate_phone_number.php";

session_start();
$now = time();

if (!empty($_SESSION['id'])) {
    if ($now > $_SESSION['expires_at']) header("location:/moha/src/logout.php");
    else header("location:/moha/{$_SESSION['role']}/index.php");
}

$name = $_POST['name'] ?? "";
$phone_number = $_POST['phone_number'] ?? "";
$state_id = $_POST['state'] ?? "";
$password = $_POST['password'] ?? "";
$role_name = "customer";



if (isset($_POST['register'])) {

    if (validate_phone_number($phone_number) == null) {
        $server_response = "Invalid phone number";
    }

    if (empty($server_response)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM role WHERE name=:role");
            $stmt->execute([
                'role' => $role_name,
            ]);
            $role = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = $pdo->prepare("SELECT * FROM user WHERE phone_number=:phone_number");
            $stmt->execute([
                'phone_number' => validate_phone_number($phone_number),
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() === 0) {
                $stmt = $pdo->prepare("INSERT INTO user (name, phone_number, password, role, state) VALUES(:name, :phone_number, :password, :role, :state)");
                $stmt->execute([
                    'name' => $name,
                    'phone_number' => validate_phone_number($phone_number),
                    'password' => $password,
                    'role' => $role['id'],
                    'state' => $state_id,
                ]);

                $_SESSION['id'] = $pdo->lastInsertId();
                $_SESSION['name'] = $name;
                $_SESSION['role'] = "customer";
                $_SESSION['state'] = $state_id;
                $_SESSION['expires_at'] = time() + 24 * 60 * 60;
                $_SESSION['cart'] = [];
                header("location:/moha/customer/index.php");
            } else {
                $server_response = "Phone number is already registered with another user.";
            }
        } catch (PDOException $e) {
            $server_response = $e->getMessage();
        }
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
        <?php
        if (!empty($server_response)) { ?>
            <p><?php echo $server_response ?></p>
        <?php } ?>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Full name" required />
        <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" placeholder="Phone number" required />
        <?php
        $stmt = $pdo->prepare("SELECT * FROM state");
        $stmt->execute();
        $states = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) { ?>
            <select name="state" id="state" required>
                <option value="" selected disabled hidden>State</option>
                <?php
                foreach ($states as $state) { ?>
                    <option value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
                <?php }
                ?>
            </select>

        <?php }
        ?>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder="Password" required />
        <button id="register" name="register" type="submit">Register</button>
    </form>
</body>



<script src="https://unpkg.com/ethiopian-phone/dist/ethiopian-phone.min.js"></script>

</html>