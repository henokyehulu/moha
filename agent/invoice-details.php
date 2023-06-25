<?php
include_once("../config.php");
include_once("../src/needs_auth.php");
if (count($_SESSION['cart']) == 0) {
    header("location:/moha/admin/order.php");
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

<html lang="en">

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
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Invoice <strong class="text-primary small">#746F5K2</strong></h3>
                                        <div class="nk-block-des text-soft">
                                            <ul class="list-inline">
                                                <li>Created At: <?php echo date('m/d/Y H:i:s', $_SESSION['expires_at']); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="/moha/agent/cart.php" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                        <a href="/moha/agent/cart.php" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="invoice">
                                    <div class="invoice-action">
                                        <a>
                                            <form method="post">
                                                <button name="make_order" type="submit" class="btn btn-info">Make order</button>
                                            </form>
                                        </a>
                                    </div><!-- .invoice-actions -->
                                    <div class="invoice-wrap">
                                        <div class="invoice-brand text-center">
                                            <img src="./images/moha_logo.jpg" srcset="./images/moha_logo.jpg 2x" alt="">
                                        </div>
                                        <div class="invoice-head">
                                            <div class="invoice-contact">
                                                <span class="overline-title">Invoice To</span>
                                                <div class="invoice-contact-info">
                                                    <h4 class="title"><?php echo $user_name ?></h4>
                                                    <ul class="list-plain">
                                                        <li><em class="icon ni ni-map-pin-fill"></em><span>House #65, 4328 Marion Street<br>Newbury, VT 05051</span></li>
                                                        <li><em class="icon ni ni-call-fill"></em><span>phone_number</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="invoice-desc">
                                                <h3 class="title">Invoice</h3>
                                                <ul class="list-plain">
                                                    <li class="invoice-id"><span>Invoice ID</span>:<span>66K5W3</span></li>
                                                    <li class="invoice-date"><span>Date</span>:<span><?php echo date('m/d/Y') ?></span></li>
                                                </ul>
                                            </div>
                                        </div><!-- .invoice-head -->
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-150px">Product ID</th>
                                                            <th class="w-60">Description</th>
                                                            <th>Price</th>
                                                            <th>Cast</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (empty($products)) : ?>
                                                            <tr>
                                                                <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                                                            </tr>
                                                        <?php else : ?>
                                                            <?php foreach ($products as $product) : ?>

                                                                <tr>
                                                                    <td>24108054</td>
                                                                    <td>
                                                                        <p><?php echo $product['name'] ?></p>
                                                                    </td>
                                                                    <td class="price">&dollar;<?php echo $product['price'] ?></td>
                                                                    <td><?php echo $products_in_cart[$product['id']] ?></td>
                                                                    <td class="price">&dollar;<?php echo $product['price'] * $products_in_cart[$product['id']] * 24 ?></td>
                                                                </tr>

                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">Subtotal</td>
                                                            <td>&dollar;<?php echo $subtotal ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">TAX</td>
                                                            <td>&dollar;<?php echo $subtotal * (15 / 100); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">Grand Total</td>
                                                            <td>&dollar;<?php echo $subtotal + $subtotal * (15 / 100); ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="nk-notes ff-italic fs-12px text-soft"> Invoice was created on a computer and is valid without the signature and seal. </div>
                                            </div>
                                        </div><!-- .invoice-bills -->
                                    </div><!-- .invoice-wrap -->
                                </div><!-- .invoice -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>