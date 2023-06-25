<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- sidebar @s -->
        <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
            <div class="nk-sidebar-element nk-sidebar-head">
                <div class="nk-sidebar-brand">
                    <a href="/moha/admin/index.php" class="logo-link nk-sidebar-logo">
                        <img class="logo-light logo-img" src="./images/logo-alt.png" srcset="./images/logo-alt.png 2x" alt="logo">
                        <img class="logo-dark logo-img" src="./images/logo-alt.png" srcset="./images/logo-alt.png 2x" alt="logo-dark">
                        <img class="logo-small logo-img logo-img-small" src="./images/logo-alt.jpg" srcset="./images/logo-alt 2x" alt="logo-small">
                    </a>
                </div>
                <div class="nk-menu-trigger me-n2">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                    <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                </div>
            </div><!-- .nk-sidebar-element -->
            <div class="nk-sidebar-element">
                <div class="nk-sidebar-content">
                    <div class="nk-sidebar-menu" data-simplebar>
                        <ul class="nk-menu"><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Dashboard</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/moha/admin/index.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-grid-alt-fill"></em></span>
                                    <span class="nk-menu-text">Dashboard</span>
                                </a>

                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Management</h6>
                            </li>

                            <li class="nk-menu-item ">
                                <a href="/moha/admin/AddProducts.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                    <span class="nk-menu-text">Add Product</span>
                                </a>

                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="admin/requests.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-bell"></em></span>
                                    <span class="nk-menu-text">Agent Requests</span><span class="nk-menu-badge">New(<?php echo $requests['total'] ?? "0" ?>)</span>
                                </a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="/moha/admin/agent-orders.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                                    <span class="nk-menu-text">Agent Order</span>
                                </a>
                            </li>
                            <!-- .nk-menu-sub -->
                            </li><!-- .nk-menu-item -->
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Management</h6>
                            </li>
                            <!-- .nk-menu-item -->
                            <li class="nk-menu-item ">
                                <a href="/moha/admin/ManageAgent.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                                    <span class="nk-menu-text">Manage Agent</span>
                                </a>
                            </li>
                            </li>

                            <li class="nk-menu-item ">
                                <a href="/moha/admin/ManageProduct.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                    <span class="nk-menu-text">Manage product</span>
                                </a>

                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item ">
                                <a href="/moha/admin/store.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                    <span class="nk-menu-text">Manage store</span>
                                </a>

                            <li class="nk-menu-item ">
                                <a href="/moha/admin/ad.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                    <span class="nk-menu-text">Post Advertisement</span>
                                </a>

                            </li><!-- .nk-menu-item -->
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Report</h6>
                            </li>

                            <li class="nk-menu-item ">
                                <a href="/moha/admin/agent-orders.php" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                    <span class="nk-menu-text">Transaction</span>
                                </a>

                            </li>
                            <!-- .nk-menu-item -->


                    </div><!-- .nk-sidebar-menu -->
                </div><!-- .nk-sidebar-content -->
            </div><!-- .nk-sidebar-element -->
        </div>
        <!-- sidebar @e -->