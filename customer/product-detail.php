<?php
include_once "../config.php";
include_once "../src/needs_auth.php";
$product_id = (int)$_REQUEST['id'];
$server_error = [];
$stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($product)) {
    header("location:/moha/customer/order.php");
}
if (isset($_POST['add_to_cart'])) {
    $creat = (int) $_POST['crate'];

    if (array_key_exists($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$product_id] += $creat;
    } else {
        $_SESSION['cart'][$product_id] = $creat;
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
    <title>Customer | Product detail</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include_once "../customer/lib/sidebar.php" ?>

            <!-- sidebar @s -->

            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php include_once "../customer/lib/header.php" ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between g-3">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Product Detail</h3>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <a href="/moha/customer/order.php" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                            <a href="/moha/customer/order.php" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card">
                                        <div class="card-inner">
                                            <div class="row pb-5">
                                                <div class="col-lg-6">
                                                    <div class="product-gallery me-xl-1 me-xxl-5">
                                                        <!-- <img src="./images/product/lg-a.jpg" class="rounded w-100" alt=""> -->
                                                        <img src="<?php echo $product['image'] ?? "./images/no-image.png" ?>" class="rounded w-100" style="object-fit: cover;" alt="product-image" height="400" />
                                                    </div><!-- .product-gallery -->
                                                </div><!-- .col -->
                                                <div class="col-lg-6">
                                                    <div class="product-info mt-5 me-xxl-5">
                                                        <h4 class="product-price text-primary">$<?php echo $product['price'] ?></h4>
                                                        <h2 class="product-title"><?php echo $product['name'] ?></h2>
                                                        <div class="product-excrept text-soft">
                                                            <p class="lead"><?php echo $product['description'] ?></p>
                                                        </div>
                                                        <div class="product-meta">
                                                            <ul class="d-flex g-3 gx-5">
                                                                <li>
                                                                    <div class="fs-14px text-muted">Product ID</div>
                                                                    <div class="fs-16px fw-bold text-secondary">#<?php echo $product['id'] ?></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-meta">
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
                                                            <form method="post" class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                                                <li class="w-140px">
                                                                    <div method="post" class="form-control-wrap number-spinner-wrap">
                                                                        <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                                                        <input name="crate" type="number" class="form-control number-spinner" value="1" min="1">
                                                                        <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <button name="add_to_cart" type="submit" class="btn btn-primary">Add to Cart</button>
                                                                </li>
                                                                </ul>
                                                            </form><!-- .product-meta -->
                                                        </div><!-- .product-info -->
                                                    </div><!-- .col -->
                                                </div><!-- .row -->
                                            </div>
                                        </div>
                                    </div><!-- .nk-block -->
                                </div>
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
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>