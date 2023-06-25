<?php
include_once "../config.php";
include_once "../src/needs_auth.php";
$stmt = $pdo->prepare("SELECT * FROM  product");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['add_to_cart'])) {
    $product_id = (int) $_POST['id'];
    $creat = 1;

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
    <title>Agent | Order</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <?php include_once "../agent/lib/sidebar.php" ?>
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <?php include_once "../agent/lib/header.php" ?>

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
                                    </div><!-- .nk-block-between -->
                                </div>
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <?php
                                        if (empty($products)) {

                                            echo "No products added yet.";
                                        } else {
                                            foreach ($products as $product) { ?>
                                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                                    <div class="card card-bordered product-card">
                                                        <div class="product-thumb">
                                                            <a href="/moha/agent/product-detail.php?id=<?php echo $product['id'] ?>">
                                                                <img src="<?php echo $product['image'] ?? "./images/no-image.png" ?>" class="card-img-top" style="object-fit: cover;" alt="product-image" height="200" />
                                                            </a>
                                                        </div>
                                                        <div class=" card-inner text-center">
                                                            <h5 class="product-title"><a href="/moha/agent/product-detail.php"> <?php echo $product['name'] ?>
                                                                </a></h5>
                                                            <div class="product-price text-primary h5">$ <?php echo $product['price'] ?>
                                                            </div>
                                                            <form method="post">
                                                                <input type="text" name="id" value="<?php echo $product['id'] ?>" hidden>
                                                                <button name="add_to_cart" type="submit" class="btn btn-primary"><em class="icon ni ni-cart"></em><span>Quick add</span>
                                                                    </a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php       }
                                        }
                                        ?>
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