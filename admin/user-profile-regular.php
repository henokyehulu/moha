<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT * FROM user where id=:id");
$stmt->execute([
    'id' => $user_id,
]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<html lang="en">

<head>
    <title>Moha|Agent Dashboard </title>
    <?php include("../admin/partials/header.php"); ?>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../admin/partials/sidebar.php"); ?>
        <!-- wrap @s -->
        <div class="nk-wrap ">
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
                                                            <p>Basic info, like your name and address</p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="/moha/admin/user-profile-regular.php" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
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
                                                            <span class="data-value"><?php echo $customer['name'] ?></span>
                                                        </div>
                                                    </div><!-- data-item -->

                                                    <div class="data-item">
                                                        <div class="data-col">
                                                            <span class="data-label">Email</span>
                                                            <span class="data-value">...</span>
                                                        </div>
                                                        <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                                    </div><!-- data-item -->
                                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                        <div class="data-col">
                                                            <span class="data-label">Phone Number</span>
                                                            <span class="data-value text-soft"><?php echo $customer['phone_number'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block -->
                                        </div>
                                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                            <div class="card-inner-group" data-simplebar>
                                                <div class="card-inner">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-primary">
                                                            <span></span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text"><?php echo $customer['name'] ?></span>
                                                            <span class="sub-text">...</span>
                                                        </div>
                                                    </div><!-- .user-card -->
                                                </div><!-- .card-inner -->
                                                <div class="card-inner">
                                                    <div class="user-account-info py-0">
                                                        <h6 class="overline-title-alt">USER ID</h6>
                                                        <div class="user-balance"><?php echo $customer['id'] ?><small class="currency currency-btc"></small></div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0">
                                                    <ul class="link-list-menu">
                                                        <li><a class="active" href="/moha/admin/user-profile-regular.php"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                                                        <li><a href="admin/edit-profile.php"><em class="icon ni ni-edit"></em><span>Edit profile</span></a></li>
                                                        <li><a href="admin/change-password.php"><em class="icon ni ni-lock-alt-fill"></em><span>Change password</span></a></li>
                                                        <li><a href="admin/delete-account.php"><em class="icon ni ni-trash"></em><span>Delete account</span></a></li>
                                                        <li><a href="/moha/src/logout.php"><em class="icon ni ni-signout"></em>Loge out</a></li>

                                                    </ul>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card-inner-group -->
                                        </div><!-- card-aside -->
                                    </div><!-- .card-aside-wrap -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>