<?php

require_once "config.php";
require_once "./src/validate_phone_number.php";

session_start();
$now = time();
$is_loading = false;
if (!empty($_SESSION['id'])) {
    if ($now > $_SESSION['expires_at']) header("location:/moha/src/logout.php");
    else header("location:/moha/{$_SESSION['role']}/index.php");
}

$phone_number = $_POST['phone_number'] ?? "";
$password = $_POST['password'] ?? "";
if (isset($_POST['login'])) {
    $server_error = "";
    $is_loading = true;
    if (validate_phone_number($phone_number) == null) {
        $server_error = "Invalid phone number.";
        $is_loading = false;
    }
    if (empty($server_error)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE phone_number=:phone_number AND password=:password");
            $stmt->execute([
                'phone_number' => validate_phone_number($phone_number),
                'password' => $password,
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                $stmt = $pdo->prepare("SELECT role.name FROM user INNER JOIN role ON {$row['role']}=role.id");
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
                        $server_error = "Error occured trying to log you in.";
                        session_destroy();
                        break;
                }
            } else {
                $server_error = "Invalid phone number or password.";
                $is_loading = false;
            }
        } catch (PDOException $e) {
            $server_error = $e->getMessage();
            $is_loading = false;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="MOHA.">
    <link rel="shortcut icon" href="/moha/images/favicon.png">
    <title>Login</title>
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
                                        <h5 class="nk-block-title">Login</h5>
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
                                            <label class="form-label" for="phone_number">
                                                Phone number
                                            </label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="tel" name="phone_number" class="form-control form-control-lg" id="phone_number" value="<?php echo $phone_number; ?>" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                            <!-- <a class="link link-primary link-sm"
                                                href="/moha/pages/auths/auth-reset-v2.html">Forgot Code?</a> -->
                                        </div>
                                        <div class="form-control-wrap">
                                            <a class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" name="password" class="form-control form-control-lg" id="password" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button <?php if ($is_loading) { ?> disabled <?php } ?> type="submit" name="login" class="btn btn-lg btn-primary btn-block">Login</button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4"> New on our platform?
                                </div>
                                <div class="text-center pt-4 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>Create an account for</span>
                                    </h6>
                                </div>
                                <ul class="nav justify-center gx-4">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/moha/register/agent.php">Agent</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/moha/register/customer.php">Customer</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="nk-block nk-auth-footer">
                                <!-- <div class="nk-block-between">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item"><a class="nav-link" href="#">Terms & Condition</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Privacy Policy</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                                        <li class="nav-item dropup"><a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-bs-toggle="dropdown" data-offset="0,10"><small>English</small></a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <ul class="language-list">
                                                    <li><a href="#" class="language-item"><img src="/moha/images/flags/english.png" alt="" class="language-flag"><span class="language-name">English</span></a></li>
                                                    <li><a href="#" class="language-item"><img src="/moha/images/flags/spanish.png" alt="" class="language-flag"><span class="language-name">Español</span></a></li>
                                                    <li><a href="#" class="language-item"><img src="/moha/images/flags/french.png" alt="" class="language-flag"><span class="language-name">Français</span></a></li>
                                                    <li><a href="#" class="language-item"><img src="/moha/images/flags/turkey.png" alt="" class="language-flag"><span class="language-name">Türkçe</span></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div> -->
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