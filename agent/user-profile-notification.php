<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <title>Moha|Agent Dashboard </title>
    <?php include("../agent/partials/header.php"); ?>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../agent/partials/sidebar.php"); ?>

        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php include("../agent/partials/sidebar.php"); ?>
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
                                                        <h4 class="nk-block-title">Notification Settings</h4>
                                                        <div class="nk-block-des">
                                                            <p>You will get only notification what have enabled.</p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="nk-block-head nk-block-head-sm">
                                                <div class="nk-block-head-content">
                                                    <h6>Security Alerts</h6>
                                                    <p>You will get only those email notification what you want.</p>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="nk-block-content">
                                                <div class="gy-3">
                                                    <div class="g-item">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" checked id="unusual-activity">
                                                            <label class="custom-control-label" for="unusual-activity">Email me whenever encounter unusual activity</label>
                                                        </div>
                                                    </div>
                                                    <div class="g-item">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="new-browser">
                                                            <label class="custom-control-label" for="new-browser">Email me if new browser is used to sign in</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-content -->
                                            <div class="nk-block-head nk-block-head-sm">
                                                <div class="nk-block-head-content">
                                                    <h6>News</h6>
                                                    <p>You will get only those email notification what you want.</p>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="nk-block-content">
                                                <div class="gy-3">
                                                    <div class="g-item">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" checked id="latest-sale">
                                                            <label class="custom-control-label" for="latest-sale">Notify me by email about sales and latest news</label>
                                                        </div>
                                                    </div>
                                                    <div class="g-item">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="feature-update">
                                                            <label class="custom-control-label" for="feature-update">Email me about new features and updates</label>
                                                        </div>
                                                    </div>
                                                    <div class="g-item">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" checked id="account-tips">
                                                            <label class="custom-control-label" for="account-tips">Email me about tips on using account</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-content -->
                                        </div>
                                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                            <div class="card-inner-group">
                                                <div class="card-inner">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-primary">
                                                            <span>AB</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text">Abu Bin Ishtiyak</span>
                                                            <span class="sub-text">info@softnio.com</span>
                                                        </div>
                                                        <div class="user-action">
                                                            <div class="dropdown">
                                                                <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .user-card -->
                                                </div><!-- .card-inner -->
                                                <div class="card-inner">
                                                    <div class="user-account-info py-0">
                                                        <h6 class="overline-title-alt">Account Balance</h6>
                                                        <div class="user-balance">12.395769 <small class="currency currency-btc">USD</small></div>
                                                        <div class="user-balance-sub">Pending <span>0.344939 <span class="currency currency-btc">USD</span></span></div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0">
                                                    <ul class="link-list-menu">
                                                        <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                                                        <li><a class="active" href="html/user-profile-notification.html"><em class="icon ni ni-bell-fill"></em><span>Notifications</span></a></li>
                                                        <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                                        <li><a href="html/user-profile-setting.html"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
                                                    </ul>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card-inner-group -->
                                        </div><!-- card-aside -->
                                    </div><!-- .card-inner -->
                                </div><!-- .card-aside-wrap -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer @s -->
            <?php include("../agent/partials/footer.php"); ?>
            <!-- footer @e -->
            <!-- JavaScript -->
            <script src="./assets/js/bundle.js?ver=3.1.3"></script>
            <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>