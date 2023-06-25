<?php
include_once("../config.php");
include_once("../src/needs_auth.php");
if (count($_SESSION['cart']) == 0) {
    header("location:/moha/agent/order.php");
}

$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$agent = $stmt->fetch(PDO::FETCH_ASSOC);

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
$shipping = 0;
$tax = 0.00;
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
    $tax = $shipping + $subtotal * 0.15;
    $total = $shipping + $subtotal + $tax;
}

if (isset($_POST['make_order'])) {

    if (is_null($agent['address_1'])) {
        echo "<script>
        window.location.href='/moha/agent/edit-address.php';
        alert('Please provide an address to proceed to payment!');
        </script>";
    } else if ($agent['status'] != "active") {
        echo "<script>
        window.location.href='/moha/agent/index.php';
        alert('Your account is not active. Please contact support@moha.com');
        </script>";
    } else {
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
                                            <a href="/moha/agent/cart.php" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                            <a href="html/product-list.html" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-7 card p-4">
                                            <div class="invoice-bills">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th class="w-150px">Product ID</th>
                                                                <th class="w-60">Name</th>
                                                                <th>Price</th>
                                                                <th>Qty</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (empty($products)) {
                                                                echo "<pre>";
                                                                var_dump($products);
                                                                echo "</pre>";
                                                                echo "No products added yet.";
                                                            } else {
                                                                foreach ($products as $product) { ?>
                                                                    <tr>
                                                                        <td><?php echo $product['id'] ?></td>
                                                                        <td><?php echo $product['name'] ?></td>
                                                                        <td>$<?php echo $product['price'] ?></td>
                                                                        <td><?php echo $products_in_cart[$product['id']] ?></td>
                                                                        <td>$<?php echo $product['price'] * $products_in_cart[$product['id']] * 24 ?></td>
                                                                    </tr>

                                                            <?php       }
                                                            }
                                                            ?>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">Subtotal</td>
                                                                <td>$<?php echo $subtotal ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">Shipping</td>
                                                                <td>$<?php echo $shipping ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">TAX</td>
                                                                <td>$<?php echo $tax ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">Grand Total</td>
                                                                <td>$<?php echo $total ?></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="card">
                                                <div class="card-inner-group">
                                                    <div class="card-inner card-inner-md">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Payment options</h6>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                    <form method="post" class="card-inner">
                                                        <div class="nk-wg-action">
                                                            <div class="nk-wg-action-content">
                                                                <em class="icon ni ni-cc-alt-fill"></em>
                                                                <div class="title">Tele birr</div>
                                                                <p>Send the total amount to merchant id <strong>7129074102943</strong>.</p>
                                                            </div>
                                                            <button type="submit" name="make_order" class="btn btn-icon btn-trigger me-n2"><em class="icon ni ni-forward-ios"></em></button>
                                                        </div>
                                                    </form><!-- .card-inner -->
                                                    <form method="post" class="card-inner">
                                                        <div class="nk-wg-action">
                                                            <div class="nk-wg-action-content">
                                                                <em class="icon ni ni-help-fill"></em>
                                                                <div class="title">CBE mobile banking</div>
                                                                <p>Send the total amount to account number: 100008304823948 and send the recipt to <strong>payment@moha.com</strong> </p>
                                                            </div>
                                                            <button type="submit" name="make_order" class="btn btn-icon btn-trigger me-n2"><em class="icon ni ni-forward-ios"></em></button>
                                                        </div>
                                                    </form><!-- .card-inner -->
                                                </div><!-- .card-inner-group -->
                                            </div><!-- .card -->
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
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
    <script src="./assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>