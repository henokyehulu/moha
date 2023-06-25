<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <title>Moha|Agent Dashboard </title>
    <?php include("../agent/partials/header.php");
    session_start();
    ?>
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
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content ">
                <div class="container">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Products</h3>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni ni-search"></em>
                                                            </div>
                                                            <input type="text" class="form-control" id="default-04" placeholder="Quick search by id">
                                                        </div>
                                                    </li>
                                                    <?php
                                                    $count = 0;
                                                    if (isset($_SESSION['cart'])) {
                                                        $count = count($_SESSION['cart']);
                                                    }
                                                    ?>
                                                    <a href="agent/mycart.php" class="btn btn-outline-success">My cart (<?php echo $count; ?>)</a>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <div class="card card-bordered product-card">
                                            <form action="agent/manage_cart.php" method="POST">
                                                <div class="product-thumb">
                                                    <img class="card-img-top" src="./images/product/Tossa.jpg" alt="">
                                                    </a>
                                                    <ul class="product-badges">
                                                        <li><span class="badge bg-success">New</span></li>
                                                    </ul>
                                                </div>
                                                <div class="card-inner text-center">
                                                    <ul class="product-tags">
                                                        <li><a href="#">Tossa Water</a></li>
                                                    </ul>
                                                    <h5 class="product-title"><a href="#">Tossa minch natural spring water</a></h5>
                                                    <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$35</small> $30</div>
                                                    <button type="submit" name="Add_To_Cart" class="btn btn-info">Add To Cart</button>
                                                    <input type="hidden" name="Item_Name" value="tossa">
                                                    <input type="hidden" name="Price" value="30">
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <div class="card card-bordered product-card">
                                            <div class="product-thumb">
                                                <form action="agent/manage_cart.php" method="POST">
                                                    <img class="card-img-top" src="./images/product/Kool_Water.jpg" alt="">
                                                    </a>

                                            </div>
                                            <div class="card-inner text-center">
                                                <ul class="product-tags">
                                                    <li><a href="#">Kool Mineral Water</a></li>
                                                </ul>
                                                <h5 class="product-title"><a href="agent/product-details.php">Kool Carbonated natural mineral water</a></h5>
                                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$29</small> $20</div>
                                                <button type="submit" name="Add_To_Cart" class="btn btn-info">Add To Cart</button>
                                                <input type="hidden" name="Item_Name" value="Kool">
                                                <input type="hidden" name="Price" value="20">
                                            </div>
                                            </form>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <div class="card card-bordered product-card">
                                            <div class="product-thumb">
                                                <form action="agent/manage_cart.php" method="POST">
                                                    <img class="card-img-top" src="./images/product/7UP.jpg" alt="">
                                                    </a>
                                                    <ul class="product-badges">
                                                        <li><span class="badge bg-blue">cool</span></li>
                                                    </ul>
                                            </div>
                                            <div class="card-inner text-center">
                                                <ul class="product-tags">
                                                    <li><a href="#">7 UP</a></li>
                                                </ul>
                                                <h5 class="product-title"><a href="agent/product-details.php">7 UP</a></h5>
                                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$29</small> $20</div>
                                                <button type="submit" name="Add_To_Cart" class="btn btn-info">Add To Cart</button>
                                                <input type="hidden" name="Item_Name" value="7up">
                                                <input type="hidden" name="Price" value="20">
                                            </div>
                                            </form>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <div class="card card-bordered product-card">
                                            <div class="product-thumb">
                                                <form action="agent/manage_cart.php" method="POST">
                                                    <img class="card-img-top" src="./images/product/Pepsi.jpg" alt="">
                                                    </a>
                                            </div>
                                            <div class="card-inner text-center">
                                                <ul class="product-tags">
                                                    <li><a href="#">PEPSI</a></li>
                                                </ul>
                                                <h5 class="product-title"><a>Pepsi</a></h5>
                                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$29</small> $20</div>
                                                <button type="submit" name="Add_To_Cart" name="Add_To_Cart" class="btn btn-info">Add To Cart</button>
                                                <input type="hidden" name="Item_Name" value="pepsi">
                                                <input type="hidden" name="Price" value="20">
                                            </div>
                                            </form>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <div class="card card-bordered product-card">
                                            <div class="product-thumb">
                                                <form action="agent/manage_cart.php" method="POST">
                                                    <img class="card-img-top" src="./images/product/Mirinida.jpg" alt="">
                                                    </a>
                                            </div>
                                            <div class="card-inner text-center">
                                                <ul class="product-tags">
                                                    <li><a href="#">Mirinda</a></li>
                                                </ul>
                                                <h5 class="product-title"><a href="html/product-details.html">Mirinda</a></h5>
                                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$29</small> $20</div>
                                                <button type="submit" name="Add_To_Cart" class="btn btn-info">Add To Cart</button>
                                                <input type="hidden" name="Item_Name" value="mirinda">
                                                <input type="hidden" name="Price" value="20">
                                            </div>
                                            </form>
                                        </div>
                                    </div><!-- .col -->
                                    </form>
                                </div>
                            </div><!-- .nk-block -->

                            <!-- footer @s -->
                            <?php include("../agent/partials/footer.php"); ?>
                            <!-- footer @e -->








                            <!-- JavaScript -->
                            <script src="./assets/js/bundle.js?ver=3.1.3"></script>
                            <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>