<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$order_id = $_REQUEST['id'];

$stmt = $pdo->prepare("SELECT customer_order.status, customer_order.amount,customer_order.customer,customer_order.created_at,customer.name AS customer_name, customer.state AS customer_state ,customer.address_1 AS customer_address_1, customer.address_2 AS customer_address_2, customer.phone_number AS customer_phone_number, state.name AS state_name FROM customer_order INNER JOIN user AS customer ON customer.id = customer_order.customer INNER JOIN state  ON customer.state = state.id WHERE customer_order.id = ?");
$stmt->execute([$order_id]);
$invoice = $stmt->fetch(PDO::FETCH_ASSOC);

$subtotal = 0.00;
$shipping = 0;
$tax = 0.00;
$total = 0.00;
$stmt = $pdo->prepare("SELECT product.id AS product_id, product.name AS product_name, product.description AS product_description, product.price AS product_price, orderandproduct_customer.quantity AS product_quantity FROM orderandproduct_customer INNER JOIN product ON product.id = orderandproduct_customer.product_id WHERE orderandproduct_customer.order_id = ? ");
$stmt->execute([$order_id]);
$invoice_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($invoice_detail as $detail) {
    $subtotal += (float)($detail['product_price'] * (int)$detail['product_quantity'] * 24);
    $shipping += $detail['product_quantity'] * 50;
}
$tax = $shipping + $subtotal * 0.15;
$total = $shipping + $subtotal + $tax;



if ($invoice['customer'] !== $user_id || empty($order_id) || $invoice['status'] != 'success') {
    header("location:my-orders.php");
}

?>
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
    <title>Invoice Print | DashLite Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="bg-white" onload="printPromot()">
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Invoice <strong class="text-primary small">#<?php echo $order_id ?></strong></h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>Created At: <span class="text-base"><?php echo date("d M, Y h:m A", strtotime($invoice['created_at'])) ?></span></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="invoice">

                            <div class="invoice-wrap">
                                <div class="invoice-brand text-center">
                                    <img src="./images/logo-dark.png" srcset="./images/logo-alt.png 2x" alt="">
                                </div>
                                <div class="invoice-head">
                                    <div class="invoice-contact">
                                        <span class="overline-title">Invoice To</span>
                                        <div class="invoice-contact-info">
                                            <h4 class="title"><?php echo $invoice['customer_name'] ?></h4>
                                            <ul class="list-plain">
                                                <li><em class="icon ni ni-map-pin-fill"></em><span><?php echo $invoice['customer_address_1'] ?? "---" ?><br><?php echo $invoice['state_name'] ?>, Addis Ababa</span></li>
                                                <li><em class="icon ni ni-call-fill"></em><span><?php echo $invoice['customer_phone_number'] ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="invoice-desc">
                                        <h3 class="title">Invoice</h3>
                                        <ul class="list-plain">
                                            <li class="invoice-id"><span>Invoice ID</span>:<span><?php echo $order_id ?></span></li>
                                            <li class="invoice-id"><span>Customer ID</span>:<span><?php echo $invoice['customer'] ?></span></li>
                                            <li class="invoice-date"><span>Date</span>:<span><?php echo date("d M, Y", strtotime($invoice['created_at'])) ?></span></li>
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
                                                    <th>Qty(crate)</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($invoice_detail as $detail) { ?>
                                                    <tr>
                                                        <td><?php echo $detail['product_id'] ?></td>
                                                        <td><?php echo $detail['product_description'] ?></td>
                                                        <td>$<?php echo $detail['product_price'] ?></td>
                                                        <td><?php echo $detail['product_quantity'] ?></td>
                                                        <td>$<?php echo (int)$detail['product_quantity'] * (int)$detail['product_price'] * 24 ?></td>
                                                    </tr>
                                                <?php }
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
                                                    <td colspan="2">Processing fee</td>
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
                                        <div class="nk-notes ff-italic fs-12px text-soft"> Invoice was created on a computer and is valid without the signature and seal. </div>
                                    </div>
                                </div><!-- .invoice-bills -->
                            </div><!-- .invoice-wrap -->
                        </div><!-- .invoice -->
                    </div><!-- .nk-block -->
                    <script>
                        function printPromot() {
                            window.print();
                        }
                    </script>


</body>

</html>