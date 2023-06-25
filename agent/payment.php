Henok, [6/24/2023 12:33 PM]
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
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
$shipping = 0.00;
$total = 0.00;
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_keys($products_in_cart));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $subtotal += (float)($product['price'] * (int)$products_in_cart[$product['id']] * 24);
    }
    $shipping += array_sum($products_in_cart) * 50;
    $total = $shipping + $subtotal;
}
if (isset($_POST['make_order'])) {
    $stmt = $pdo->prepare("INSERT INTO agent_order (agent, amount) VALUES(:agent_id, :amount)");
    $stmt->execute([
        'agent_id' => intval($user_id),
        'amount' => $total,
    ]);
    $order_id = $pdo->lastInsertId();

    foreach ($products as $product) {
        $stmt = $pdo->prepare("INSERT INTO orderandproduct_agent (order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)");
        $stmt->execute([
            'order_id' => $order_id,
            'product_id' => $product['id'],
            'quantity' => (int)$products_in_cart[$product['id']],
        ]);
    }


    $_SESSION['cart'] = [];

    echo "<script>
        window.location.href='/moha/agent/my-orders.php';
        alert('Order successfully placed!');
        </script>";
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
            <!-- wrap @s -->
            <div class="nk-wrap ">

                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between g-3">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Check out</h3>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <a href="/moha/agent/checkout.php" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                            <a href="/moha/agent/checkout.php" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-6">
                                            <div class="card card-bordered product-card">
                                                <div class="product-thumb">
                                                    <a href="/moha/agent/product-detail.php?id=<?php echo $product['id'] ?>">
                                                        <img class="card-img-top" src="./images/product/lg-a.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="card-inner text-center">
                                                    <!-- <ul class="product-tags"> 
                                                                <li><a href="#"> 
                                                                        <?php echo $product['type'] ?> 
                                                                    </a></li> 
                                                            </ul> -->
                                                    <h5 class="product-title"><a href="/moha/agent/product-detail.php"> <?php echo $product['name'] ?>

                                                            Henok, [6/24/2023 12:33 PM]
                                                        </a></ Henok, [6/24/2023 12:33 PM] h5>
                                                        <div class="product-price text-primary h5">$ <?php echo $product['price'] ?>
                                                        </div>
                                                        <form method="post">
                                                            <input type="text" name="id" value="<?php echo $product['id'] ?>" hidden>
                                                            <button name="add_to_cart" type="submit" class="btn btn-primary"><em class="icon ni ni-cart"></em><span>Quick add</span> </a>
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="card-inner-group">
                                                    <div class="card-inner card-inner-md">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Payment options</h6>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                    <div class="card-inner">
                                                        <div class="nk-wg-action">
                                                            <div class="nk-wg-action-content">
                                                                <em class="icon ni ni-cc-alt-fill"></em>
                                                                <div class="title">Tele birr</div>
                                                                <p>Send the total amount to merchant id <strong>7129074102943</strong>.</p>
                                                            </div>
                                                            <a href="#" class="btn btn-icon btn-trigger me-n2"><em class="icon ni ni-forward-ios"></em></a>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                    <div class="card-inner">
                                                        <div class="nk-wg-action">
                                                            <div class="nk-wg-action-content">
                                                                <em class="icon ni ni-help-fill"></em>
                                                                <div class="title">CBE mobile banking</div>
                                                                <p>Send the total amount to <strong>payment@moha.com</strong> </p>
                                                            </div>
                                                            <a href="#" class="btn btn-icon btn-trigger me-n2"><em class="icon ni ni-forward-ios"></em></a>

                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .card-inner-group -->
                                            </div><!-- .card -->
                                            <a>
                                                <form method="post">
                                                    <button name="make_order" type="submit" class="btn btn-info">Make order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- content @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root

Henok, [6/24/2023 12:33 PM]
@e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
    <script src="./assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>