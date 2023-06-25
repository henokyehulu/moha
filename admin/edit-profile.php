<?php
include_once "../config.php";
include_once "../src/needs_auth.php";
include_once "../src/validate_phone_number.php";


$server_error = [];

$stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
$stmt->execute([
    $user_id,
]);

if ($stmt->rowCount() == 0) {
    header("location:/moha/src/logout.php");
    exit;
}

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

$form_data = [
    'name' => $_POST['name'] ?? $admin['name'],
    'phone_number' => $_POST['phone_number'] ?? $admin['phone_number'],
    'tin' => $_POST['tin'] ?? $admin['tin'],
    'email' => $_POST['email'] ?? $admin['email'],
    'id' => $admin['id']
];



if (isset($_POST['update_profile'])) {
    $phone_number = validate_phone_number($form_data['phone_number']);
    if ($phone_number == null) {
        $server_error[] = "Invalid phone number";
    }
    if ($phone_number !== $admin['phone_number']) {
        $stmt = $pdo->prepare("SELECT phone_number FROM user WHERE phone_number=:phone_number");
        $stmt->execute([
            'phone_number' => $phone_number,
        ]);
        if ($stmt->rowCount() > 0) {
            $server_error[] = "Phone number is already in use.";
        }
    }
    if (!empty($form_data['email']) && !filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $server_error[] = "Invalid email address";
    }


    if (empty($server_error)) {
        $stmt = $pdo->prepare("UPDATE user SET name=:name, phone_number=:phone_number,email=:email, tin=:tin WHERE id=:id");
        $stmt->execute([
            ...$form_data,
            'email' => empty($form_data['email']) ? null : $form_data['email'],
            'tin' => empty($form_data['tin']) ? null : $form_data['tin'],
            'phone_number' => $phone_number
        ]);
        $_SESSION['name'] = $form_data['name'];
        $server_error = [];
        echo "<script>
            window.location.href='/moha/admin/profile.php';
            alert('Profile updated successfully!');
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
    <title>Customer | Edit profile</title>
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
                                                            <a href="/moha/admin/profile.php" class="btn mb-3 btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                                            <h4 class="nk-block-title">Update personal information</h4>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block">
                                                    <div class="nk-data data-list" method="post" class="form-validate is-alter nk-data data-list">
                                                        <div>
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
                                                                    <label class="form-label" for="name">
                                                                        Full name
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="tel" name="name" class="form-control form-control-lg" id="name" value="<?php echo $form_data['name']; ?>" placeholder="Enter full name" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="phone_number">
                                                                        Phone number
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="tel" name="phone_number" class="form-control form-control-lg" id="phone_number" value="<?php echo $form_data['phone_number'];; ?>" placeholder="Enter phone number" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="email">
                                                                        Email (Optional)
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="tel" name="email" class="form-control form-control-lg" id="email" value="<?php echo $form_data['email']; ?>" placeholder="Enter email address" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" name="update_profile" class="btn btn-lg btn-primary btn-block">Update profile</button>
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