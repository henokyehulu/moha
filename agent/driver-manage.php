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
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">MY Drivers</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have total 95 Drivers.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt">
                                                        <div>
                                                    <li><a href="agent/Driver-add-form.php" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Driver</span></a></li>

                                            </div>
                                            </li>
                                            </ul>
                                        </div>
                                    </div><!-- .toggle-wrap -->
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <div class="nk-block">
                            <div class="row g-gs">
                                <div class="col-sm-6 col-lg-4 col-xxl-3">
                                    <div class="card">
                                        <div class="card-inner">
                                            <div class="team">
                                                <div class="team-status bg-danger text-white"><em class="icon ni ni-na"></em></div>
                                                <div class="team-options">
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-mail"></em><span>Send Email</span></a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-card user-card-s2">
                                                    <div class="user-avatar md bg-primary">
                                                        <span>AB</span>
                                                        <div class="status dot dot-lg dot-success"></div>
                                                    </div>
                                                    <div class="user-info">
                                                        <h6>Abu Bin Ishtiyak</h6>
                                                        <span class="sub-text">UI/UX Designer</span>
                                                    </div>
                                                </div>
                                                <ul class="team-info">
                                                    <li><span>Join Date</span><span>24 Jun 2015</span></li>
                                                    <li><span>Contact</span><span>+88 01713-123656</span></li>
                                                    <li><span>Email</span><span>info@softnio.com</span></li>
                                                </ul>
                                                <div class="team-view">
                                                    <a href="php/user-details-regular.php" class="btn btn-round btn-outline-light w-150px"><span>View Profile</span></a>
                                                </div>
                                            </div><!-- .team -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-lg-4 col-xxl-3">
                                    <div class="card">
                                        <div class="card-inner">
                                            <div class="team">
                                                <div class="team-status bg-light text-black"><em class="icon ni ni-check-thick"></em></div>
                                                <div class="team-options">
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-mail"></em><span>Send Email</span></a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-card user-card-s2">
                                                    <div class="user-avatar md bg-primary">
                                                        <img src="./images/avatar/a-sm.jpg" alt="">
                                                        <div class="status dot dot-lg dot-success"></div>
                                                    </div>
                                                    <div class="user-info">
                                                        <h6>Ashley Lawson</h6>
                                                        <span class="sub-text">@ashley</span>
                                                    </div>
                                                </div>
                                                <ul class="team-info">
                                                    <li><span>Join Date</span><span>24 Jun 2015</span></li>
                                                    <li><span>Contact</span><span>+88 01713-123656</span></li>
                                                    <li><span>Email</span><span>info@softnio.com</span></li>
                                                </ul>
                                                <div class="team-view">
                                                    <a href="php/user-details-regular.php" class="btn btn-round btn-outline-light w-150px"><span>View Profile</span></a>
                                                </div>
                                            </div><!-- .team -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-lg-4 col-xxl-3">
                                    <div class="card">
                                        <div class="card-inner">
                                            <div class="team">
                                                <div class="team-status bg-success text-white"><em class="icon ni ni-check-thick"></em></div>
                                                <div class="team-options">
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-mail"></em><span>Send Email</span></a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-card user-card-s2">
                                                    <div class="user-avatar md bg-info">
                                                        <span>JL</span>
                                                        <div class="status dot dot-lg dot-success"></div>
                                                    </div>
                                                    <div class="user-info">
                                                        <h6>Joe Larson</h6>
                                                        <span class="sub-text">@larson</span>
                                                    </div>
                                                </div>
                                                <div class="team-details">
                                                    <p>I am an UI/UX Designer.</p>
                                                </div>
                                                <ul class="team-info">
                                                    <li><span>Join Date</span><span>24 Jun 2015</span></li>
                                                    <li><span>Contact</span><span>+88 01713-123656</span></li>
                                                    <li><span>Email</span><span>info@softnio.com</span></li>
                                                </ul>
                                                <div class="team-view">
                                                    <a href="html/user-details-regular.html" class="btn btn-round btn-outline-light w-150px"><span>View Profile</span></a>
                                                </div>
                                            </div><!-- .team -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-lg-4 col-xxl-3">
                                    <div class="card">
                                        <div class="card-inner">
                                            <div class="team">
                                                <div class="team-status bg-warning text-white"><em class="icon ni ni-clock"></em></div>
                                                <div class="team-options">
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-mail"></em><span>Send Email</span></a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-card user-card-s2">
                                                    <div class="user-avatar md bg-danger">
                                                        <span>JM</span>
                                                        <div class="status dot dot-lg dot-success"></div>
                                                    </div>
                                                    <div class="user-info">
                                                        <h6>Jane Montgomery</h6>
                                                        <span class="sub-text">@jane84</span>
                                                    </div>
                                                </div>
                                                <ul class="team-info">
                                                    <li><span>Join Date</span><span>24 Jun 2015</span></li>
                                                    <li><span>Contact</span><span>+88 01713-123656</span></li>
                                                    <li><span>Email</span><span>info@softnio.com</span></li>
                                                </ul>
                                                <div class="team-view">
                                                    <a href="html/user-details-regular.html" class="btn btn-round btn-outline-light w-150px"><span>View Profile</span></a>
                                                </div>
                                            </div><!-- .team -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card -->
                                </div><!-- .col -->
                            </div>
                        </div><!-- .nk-block -->





                    </div>
                    <!-- footer @s -->
                    <?php include("../agent/partials/footer.php"); ?>
                    <!-- footer @e -->
                    <!-- JavaScript -->
                    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
                    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>