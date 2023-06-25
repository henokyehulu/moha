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

$agent = $stmt->fetch(PDO::FETCH_ASSOC);


$form_data = [
    'tin' => $_POST['tin'] ?? $agent['tin'],
    'delivery_trucks_libre' => $_POST['delivery_trucks_libre'] ?? $agent['delivery_trucks_libre'],
    'store_lease' => $_POST['store_lease'] ?? $agent['store_lease'],
];

$folder = '../uploaddocuments/';

if (isset($_POST['update_document'])) {

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $tin_path = $folder . bin2hex(random_bytes(10)) . ".pdf";

    move_uploaded_file($_FILES['tin']['tmp_name'], $tin_path);

    $delivery_trucks_libre_path = $folder . bin2hex(random_bytes(10)) . ".pdf";

    move_uploaded_file($_FILES['delivery_trucks_libre']['tmp_name'], $delivery_trucks_libre_path);
    $store_lease_path = $folder . bin2hex(random_bytes(10)) . ".pdf";

    move_uploaded_file($_FILES['store_lease']['tmp_name'], $store_lease_path);

    $stmt = $pdo->prepare("UPDATE user SET tin=:tin, delivery_trucks_libre=:delivery_trucks_libre,store_lease=:store_lease WHERE id=:id");
    $stmt->execute([
        'tin' => $tin_path,
        'delivery_trucks_libre' => $delivery_trucks_libre_path,
        'store_lease' => $store_lease_path,
        'id' => $user_id
    ]);

    echo "<script>
    window.location.href='/moha/agent/profile.php';
    alert('Documents updated successfully!');
    </script>";
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
    <title>Customer | Edit document</title>
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
                                                            <a href="/moha/agent/profile.php" class="btn mb-3 btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                                            <h4 class="nk-block-title">Update documents</h4>
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

                                                        <form method="post" class="form-validate is-alter" autocomplete="off" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="tin">
                                                                        TIN
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="file" accept="application/pdf" name="tin" class="form-control form-control-lg" id="tin" value="<?php echo $form_data['tin']; ?>" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="delivery_trucks_libre">
                                                                        Delivery trucks libre
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="file" accept="application/pdf" name="delivery_trucks_libre" class="form-control form-control-lg" id="delivery_trucks_libre" value="<?php echo $form_data['delivery_trucks_libre']; ?>" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="store_lease">
                                                                        Store lease
                                                                    </label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <input type="file" accept="application/pdf" name="store_lease" class="form-control form-control-lg" id="store_lease" value="<?php echo $form_data['store_lease']; ?>" required />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <button type="submit" name="update_document" class="btn btn-lg btn-primary btn-block">Update document</button>
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