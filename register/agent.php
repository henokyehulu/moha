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
$password = $_POST['password'] ?? "";
$state_id = $_POST['state'] ?? "";
$tin = $_POST['tin'] ?? "";
$role_name = "agent";



if (isset($_POST['register'])) {
    if (validate_phone_number($phone_number) == null) {
        $server_error = "Invalid phone number";
    }
    if (empty($server_error)) {
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
                $stmt = $pdo->prepare("INSERT INTO user (name, phone_number, password, role, state, tin) VALUES(:name, :phone_number, :password, :role, :state, :tin)");
                $stmt->execute([
                    'name' => $name,
                    'phone_number' => validate_phone_number($phone_number),
                    'password' => md5($password),
                    'role' => $role['id'],
                    'state' => $state_id,
                    'tin' => $tin,
                ]);
                $_SESSION['id'] = $pdo->lastInsertId();
                $_SESSION['name'] = $name;
                $_SESSION['role'] = "agent";
                $_SESSION['state'] = $state_id;
                $_SESSION['expires_at'] = time() + 24 * 60 * 60;
                $_SESSION['cart'] = [];
                header("location:/moha/agent/index.php");
            } else {
                $server_error = "Phone number is already registered with another user.";
            }
        } catch (PDOException $e) {
            $server_error = $e->getMessage();
        }
    }
}
?>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="MOHA.">
    <link rel="shortcut icon" href="/moha/images/favicon.png">
    <title>Agent registration</title>
    <link rel="stylesheet" href="/moha/assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="/moha/assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo">
                                    <em class="icon ni ni-info"></em>
                                </a>
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="/moha/index.html" class="logo-link">
                                        <!-- <img class="logo-light logo-img logo-img-lg" src="/moha/images/logo-alt.png" srcset="/moha/images/alt.png" alt="logo" /> -->
                                        <img class="logo-dark logo-img logo-img-lg" src="/moha/images/logo-alt.png" srcset="/moha/images/logo-alt.png" alt="logo-dark" />
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Agent registration</h5>
                                        <div class="nk-block-des">
                                            <p>Access the your panel using your phone number and password.</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (!empty($server_error)) { ?>
                                    <div class="alert  alert-icon alert-danger" role="alert">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <?php echo $server_error ?>
                                    </div>
                                <?php } ?>
                                <form method="post" class="form-validate is-alter" autocomplete="off">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="name">
                                                Full name
                                            </label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="tel" name="name" class="form-control form-control-lg" id="name" value="<?php echo $name; ?>" placeholder="Gizachew Alemu" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="tin">
                                                TIN
                                            </label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="tel" name="tin" class="form-control form-control-lg" id="tin" value="<?php echo $tin; ?>" placeholder="102030405060" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="phone_number">
                                                Phone number
                                            </label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="tel" name="phone_number" class="form-control form-control-lg" id="phone_number" value="<?php echo $phone_number; ?>" placeholder="0910203040" required />
                                        </div>
                                    </div>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT * FROM state");
                                    $stmt->execute();
                                    $states = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($stmt->rowCount() > 0) { ?>
                                        <div class="form-group">
                                            <label class="form-label">State</label>
                                            <div class="form-control-wrap">
                                                <select name="state" class="form-select js-select2" required>
                                                    <?php
                                                    foreach ($states as $state) { ?>
                                                        <option style="text-transform: capitalize;" value="<?php echo $state['id'] ?>">
                                                            <?php echo ucwords($state['name']) ?>
                                                        </option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    <?php }
                                    ?>

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="******" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="register" class="btn btn-lg btn-primary btn-block">Register</button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4">Already have an account?
                                </div>
                                <ul class="nav justify-center gx-4">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/moha/login.php">Login</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="nk-block nk-auth-footer">
                                <div class="mt-3">
                                    <p class="text-soft">&copy; 2023 MOHA products distribution system. All Rights Reserved.</p>

                                </div>
                            </div>
                        </div>
                        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                                <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="https://mohasoftdrinksindustry.com/wp-content/uploads/Pepsi-All-Moha-Soft-Drinks-Industry-Ethiopia.jpg" srcset="https://mohasoftdrinksindustry.com/wp-content/uploads/Pepsi-All-Moha-Soft-Drinks-Industry-Ethiopia.jpg 2x" alt="" style="object-fit: contain;" />
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>Pepsi</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid,
                                                    fugit!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="https://mohasoftdrinksindustry.com/wp-content/uploads/Mirinida-Moha-Soft-Drinks-Industry-Addis-Ababa-Ethiopia.jpg" srcset="https://mohasoftdrinksindustry.com/wp-content/uploads/Mirinida-Moha-Soft-Drinks-Industry-Addis-Ababa-Ethiopia.jpg 2x" alt="" style="object-fit: contain;" />
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>Mirinda</h4>
                                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. In,
                                                    ducimus.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="https://mohasoftdrinksindustry.com/wp-content/uploads/7UP-Moha-Soft-Drinks-Industry-Ethiopia.jpg" srcset="https://mohasoftdrinksindustry.com/wp-content/uploads/7UP-Moha-Soft-Drinks-Industry-Ethiopia.jpg 2x" alt="" style="object-fit: contain;" />
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>7 Up</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam,
                                                    doloremque?</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-dots"></div>
                                <div class="slider-arrows"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="/moha/assets/js/bundle.js?ver=3.1.3"></script>
    <script src="/moha/assets/js/scripts.js?ver=3.1.3"></script>
    <script src="/moha/assets/js/demo-settings.js?ver=3.1.3"></script>

</html>