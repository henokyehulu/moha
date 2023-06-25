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
                                                        <h4 class="nk-block-title">Login Activity</h4>
                                                        <div class="nk-block-des">
                                                            <p>Here is your last 20 login activities log. <span class="text-soft"><em class="icon ni ni-info"></em></span></p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="nk-block card">
                                                <table class="table table-ulogs">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="tb-col-os"><span class="overline-title">Browser <span class="d-sm-none">/ IP</span></span></th>
                                                            <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                                            <th class="tb-col-time"><span class="overline-title">Time</span></th>
                                                            <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="tb-col-os">Chrome on Window</td>
                                                            <td class="tb-col-ip"><span class="sub-text">192.149.122.128</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">11:34 PM</span></td>
                                                            <td class="tb-col-action"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Mozilla on Window</td>
                                                            <td class="tb-col-ip"><span class="sub-text">86.188.154.225</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Nov 20, 2019 <span class="d-none d-sm-inline-block">10:34 PM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Chrome on iMac</td>
                                                            <td class="tb-col-ip"><span class="sub-text">192.149.122.128</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Nov 30, 2019 <span class="d-none d-sm-inline-block">08:56 PM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Chrome on Window</td>
                                                            <td class="tb-col-ip"><span class="sub-text">192.149.122.128</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Nov 03, 2019 <span class="d-none d-sm-inline-block">04:29 PM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Mozilla on Window</td>
                                                            <td class="tb-col-ip"><span class="sub-text">86.188.154.225</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Oct 29, 2019 <span class="d-none d-sm-inline-block">09:38 AM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Chrome on iMac</td>
                                                            <td class="tb-col-ip"><span class="sub-text">192.149.122.128</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Oct 23, 2019 <span class="d-none d-sm-inline-block">04:16 PM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Chrome on Window</td>
                                                            <td class="tb-col-ip"><span class="sub-text">192.149.122.128</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Oct 20, 2019 <span class="d-none d-sm-inline-block">11:41 PM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Mozilla on Window</td>
                                                            <td class="tb-col-ip"><span class="sub-text">86.188.154.225</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Oct 29, 2019 <span class="d-none d-sm-inline-block">05:43 AM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col-os">Chrome on iMac</td>
                                                            <td class="tb-col-ip"><span class="sub-text">192.149.122.128</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">Oct 03, 2019 <span class="d-none d-sm-inline-block">04:12 AM</span></span></td>
                                                            <td class="tb-col-action"><a href="#" class="link-cross me-sm-n1"><em class="icon ni ni-cross"></em></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div><!-- .nk-block-head -->
                                        </div><!-- .card-inner -->
                                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                            <div class="card-inner-group">
                                                <div class="card-inner">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-primary">
                                                            <span>AB</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <p class="lead-text"><?php echo $user_name ?></p>
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
                                                        <li><a href="html/user-profile-notification.html"><em class="icon ni ni-bell-fill"></em><span>Notifications</span></a></li>
                                                        <li><a class="active" href="html/user-profile-activity.html"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                                        <li><a href="html/user-profile-setting.html"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
                                                    </ul>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card-inner-group -->
                                        </div><!-- card-aside -->
                                    </div><!-- card-aside-wrap -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <?php include("../agent/partials/footer.php"); ?>
            <!-- JavaScript -->
            <script src="./assets/js/bundle.js?ver=3.1.3"></script>
            <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>