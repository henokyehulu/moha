<?php
include_once "../config.php";
include_once "../src/needs_auth.php";
include_once "../src/validate_phone_number.php";

$server_error = [];

$stmt = $pdo->prepare("SELECT user.name, user.phone_number, user.email, user.address_1, user.address_2, state.name AS state_name, user.tin,user.delivery_trucks_libre,user.store_lease FROM user INNER JOIN state ON user.state = state.id WHERE user.id=?");
$stmt->execute([
    $user_id,
]);

if ($stmt->rowCount() == 0) {
    header("location:/moha/src/logout.php");
    exit;
}

$agent = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <title>Admin | Profile</title>
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
                                                            <h4 class="nk-block-title">Personal Information</h4>
                                                            <div class="nk-block-des">
                                                                <p>Basic info, like your name and address, that you use on this platform.</p>
                                                            </div>
                                                        </div>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block">
                                                    <div class="nk-data data-list">
                                                        <div class="data-head">
                                                            <h6 class="overline-title">Basics</h6>
                                                        </div>
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Full Name</span>
                                                                <span class="data-value"><?php echo $agent['name'] ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="/moha/agent/edit-profile.php" class="data-more"><em class="icon ni ni-forward-ios"></em></a></div>
                                                        </div><!-- data-item -->
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Email</span>
                                                                <span class="data-value text-soft"><?php echo $agent['email'] ?? "Not added yet ," ?> </span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="/moha/agent/edit-profile.php" class="data-more"><em class="icon ni ni-forward-ios"></em></a></div>
                                                        </div><!-- data-item -->
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Phone Number</span>
                                                                <span class="data-value text-soft"><?php echo $agent['phone_number'] ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="/moha/agent/edit-profile.php" class="data-more"><em class="icon ni ni-forward-ios"></em></a></div>
                                                        </div><!-- data-item -->
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                                            <div class="data-col">
                                                                <span class="data-label">Address</span>
                                                                <span>
                                                                    <?php echo  ucwords($agent['state_name']) ?>, Addis Ababa,<br />
                                                                    <?php echo $agent['address_1'] ?? "Address 1 not added yet ," ?> <br />
                                                                </span>
                                                                <span>
                                                                    <span></span>

                                                            </div>
                                                            <div class="data-col data-col-end"><a href="/moha/agent/edit-address.php" class="data-more"><em class="icon ni ni-forward-ios"></em></a></div>
                                                        </div><!-- data-item -->
                                                    </div>
                                                    <div class="nk-data data-list">
                                                        <div class="data-head">
                                                            <h6 class="overline-title">Document</h6>
                                                        </div>
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">TIN</span>
                                                                <span class="data-value text-soft"><?php echo $agent['tin'] ? "Added." : "Not added yet." ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="/moha/agent/edit-document.php" class="data-more"><em class="icon ni ni-forward-ios"></em></a></div>
                                                        </div><!-- data-item -->
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Delivery trucks libre</span>
                                                                <span class="data-value text-soft"><?php echo $agent['delivery_trucks_libre'] ? "Added." : "Not added yet." ?> </span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="/moha/agent/edit-document.php" class="data-more"><em class="icon ni ni-forward-ios"></em></a></div>
                                                        </div><!-- data-item -->
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Store lease</span>
                                                                <span class="data-value text-soft"><?php echo $agent['store_lease'] ? "Added." : "Not added yet." ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="/moha/agent/edit-document.php" class="data-more"><em class="icon ni ni-forward-ios"></em></a></div>
                                                        </div>
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