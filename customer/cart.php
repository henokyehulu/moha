<?php
include_once("../config.php");
include_once("../src/needs_auth.php");
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$check_out_cart = array();
$subtotal = 0.00;
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_keys($products_in_cart));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $subtotal += (float)($product['price'] * (int)$products_in_cart[$product['id']] * 24);
    }
}
$total = $subtotal;

if (isset($_POST['remove_product'])) {
    $product_id = $_POST['id'];
    unset($_SESSION['cart'][$product_id]);
    header("location:/moha/customer/cart.php");
}

if (isset($_POST['update_creat'])) {
    $product_id = $_POST['id'];
    $creat = $_POST['creat'];
    $_SESSION['cart'][$product_id] = $creat;
    header("location:/moha/customer/cart.php");
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
    header("location:/moha/customer/cart.php");
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
    <title>Customer | Order</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <?php include_once "../customer/lib/sidebar.php" ?>

            <!-- wrap @s -->
            <div class="nk-wrap ">
                <?php include_once "../customer/lib/header.php" ?>


                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">My cart</h3>
                                        </div><!-- .nk-block-head-content -->

                                        <!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block row g-gs">
                                    <div class="card col-8">
                                        <div class="card-inner-group">
                                            <div class="card-inner p-0">
                                                <div class="nk-tb-list">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col tb-col-sm"><span>Name</span></div>
                                                        <div class="nk-tb-col"><span>Price</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span>Qty</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span></span></div>
                                                    </div>
                                                    <?php if (empty($my_cart)) : ?>
                                                        <div>
                                                            <span class="p-5">You have no products added in your Shopping Cart</span>
                                                        </div>
                                                    <?php else : ?>
                                                        <?php foreach ($products as $product) : ?>
                                                            <!-- .nk-tb-item -->
                                                            <div class="nk-tb-item">
                                                                <div class="nk-tb-col tb-col-sm">
                                                                    <span class="tb-product">
                                                                        <img src="<?php echo $product['image'] ?? "./images/no-image.png" ?>" class="thumb" style="object-fit: cover;" alt="product-image" width="60" height="60" />
                                                                        <span class="title"><?php echo $product['name'] ?></span>
                                                                    </span>
                                                                </div>
                                                                <div class="nk-tb-col">
                                                                    <span class="tb-lead">$ <?php echo $product['price'] * $products_in_cart[$product['id']] * 24 ?></span>
                                                                </div>
                                                                <div class="nk-tb-col w-140px">
                                                                    <form method="post">
                                                                        <input type="text" name="id" value="<?php echo $product['id'] ?>" hidden>
                                                                        <div method="post" class="form-control-wrap number-spinner-wrap">
                                                                            <button type="submit" name="update_creat" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                                                            <input name="creat" type="number" value="<?php echo $products_in_cart[$product['id']] ?>" class="form-control number-spinner" value="1" min="1">
                                                                            <button type="submit" name="update_creat" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                <form method="post" class="nk-tb-col nk-tb-col-tools">
                                                                    <input name="id" value="<?php echo $product['id'] ?>" hidden required />
                                                                    <button name="remove_product" class="btn btn-danger btn-xs">Remove</button>
                                                                </form>
                                                            </div>
                                                            <!-- .nk-tb-item -->

                                                        <?php endforeach; ?>
                                                    <?php endif; ?>

                                                </div><!-- .nk-tb-list -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card col-4">
                                        <div class="pricing-body">
                                            <ul class="pricing-features">
                                                <li><span class="w-50">Sub total</span> - <b class="ms-auto">$<?php echo $total ?></b></li>
                                            </ul>
                                            <div class="pricing-action">
                                                <a href="/moha/customer/checkout.php" class="btn btn-outline-light">Proceed to check out</a>
                                            </div>
                                        </div>
                                    </div>
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
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
    <script src="./assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>