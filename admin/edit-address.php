<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

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
    'state' => $_POST['state'] ?? $admin['state'],
    'address_1' => $_POST['address_1'] ?? $admin['address_1'],
    'address_2' => $_POST['address_2'] ?? $admin['address_2'],
    'id' => $admin['id']
];

if (isset($_POST['update_address'])) {
    if (empty($server_error)) {
        $stmt = $pdo->prepare("UPDATE user SET state=:state, address_1=:address_1,address_2=:address_2 WHERE id=:id");
        $stmt->execute([
            ...$form_data,
            'address_2' => empty($form_data['address_2']) ? null : $form_data['address_2'],
        ]);
        $_SESSION['state'] = $form_data['state'];
        $server_error = [];
        echo "<script>
            window.location.href='/moha/admin/profile.php';
            alert('Address updated successfully!');
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
    <title>Customer | Edit address</title>
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
                                                            <h4 class="nk-block-title">Update your address</h4>
                                                        </div>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block">
                                                    <div class="nk-data data-list" method="post" class="form-validate is-alter nk-data data-list">
                                                        <form method="post" class="form-validate is-alter" autocomplete="off">

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
                                                                                <option <?php if ($admin['state'] == $state['id']) { ?> selected <?php } ?> value="<?php echo $state['id'] ?>">
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
                                                                    <label class="form-label" for="address_1">
                                                                        Address line 1
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="tel" name="address_1" class="form-control form-control-lg" id="address_1" value="<?php echo $form_data['address_1']; ?>" placeholder="Enter address" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="address_2">
                                                                        Address line 2 (Optional)
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="tel" name="address_2" class="form-control form-control-lg" id="address_2" value="<?php echo $form_data['address_2']; ?>" placeholder="Enter additional address" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" name="update_address" class="btn btn-lg btn-primary btn-block">Update address</button>
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