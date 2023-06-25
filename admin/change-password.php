<?php
include_once "../config.php";
include_once "../src/needs_auth.php";
include_once "../src/validate_phone_number.php";


$server_error = [];

$stmt = $pdo->prepare("SELECT * FROM user where id=?");
$stmt->execute([
    $user_id,
]);

if ($stmt->rowCount() == 0) {
    header("location:/moha/src/logout.php");
    exit;
}

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

$form_data = [
    'current_password' => $_POST['current_password'] ?? "",
    'new_password' => $_POST['new_password'] ?? "",
    'id' => $admin['id']
];



if (isset($_POST['change_password'])) {

    if ($admin['password'] != md5($form_data['current_password'])) {
        $server_error[] = "Current password incorrect.";
    }

    if (empty($server_error)) {
        $stmt = $pdo->prepare("UPDATE user SET password=:password WHERE id=:id");
        $stmt->execute([
            'password' => md5($form_data['new_password']),
            'id' => $form_data['id'],
        ]);
        $server_error = [];
        echo "<script>
            window.location.href='/moha/admin/profile.php';
            alert('Password changed successfully!');
            </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Customer | Change password</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <?php include_once "./lib/sidebar.php" ?>
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <?php include_once "./lib/header.php" ?>

                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block">
                                    <div class="card">
                                        <div class="card-aside-wrap">
                                            <div class="card-inner card-inner-lg">
                                                <div class="nk-block-head nk-block-head-lg">
                                                    <div class="nk-block-between">
                                                        <div class="nk-block-head-content">
                                                            <a href="/moha/admin/security.php" class="btn mb-3 btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                                            <h4 class="nk-block-title">Change password</h4>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block">
                                                    <div class="nk-data data-list" method="post" class="form-validate is-alter nk-data data-list">
                                                        <div class="">
                                                            <?php
                                                            if (count($server_error) > 0) { ?>
                                                                <ul class="mb-4">
                                                                    <?php foreach ($server_error as $error) { ?>
                                                                        <li class="alert alert-icon alert-danger list" role="alert">
                                                                            <em class="icon ni ni-alert-circle"></em>
                                                                            <?php echo $error ?>
                                                                        </li>

                                                                    <?php       } ?>
                                                                </ul>

                                                            <?php }
                                                            ?>
                                                        </div>

                                                        <form method="post" class="form-validate is-alter" autocomplete="off">
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="current_password">Current password</label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <a class="form-icon form-icon-right passcode-switch lg" data-target="current_password">
                                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                    </a>
                                                                    <input type="password" name="current_password" class="form-control form-control-lg" id="current_password" placeholder="******" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="new_password">New password</label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <a class="form-icon form-icon-right passcode-switch lg" data-target="new_password">
                                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                    </a>
                                                                    <input type="password" name="new_password" class="form-control form-control-lg" id="new_password" placeholder="******" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" name="change_password" class="btn btn-lg btn-primary btn-block">Change password</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- .nk-block -->
                                            </div>
                                            <?php include_once "./lib/profile/siderbar.php" ?>
                                        </div><!-- .card-aside-wrap -->
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <?php include_once "./lib/footer.php" ?>

                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>