<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT customer_order.id AS order_id, customer_order.created_at AS order_created_at, customer_order.status AS order_status,customer_order.amount AS order_amount, customer.name AS customer_name, SUM(orderandproduct_customer.quantity) AS order_quantity FROM customer_order INNER JOIN user AS customer ON customer.id = customer_order.customer INNER JOIN orderandproduct_customer ON orderandproduct_customer.order_id = customer_order.id WHERE customer_order.status = 'pending' AND customer.state = ?");
$stmt->execute([$user_state]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['accept_order'])) {
    $order_id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE customer_order SET status=:status,agent=:agent WHERE id=:order_id");
    $stmt->execute([
        'status' => "agent_accepted",
        'agent' => $user_id,
        'order_id' => $order_id
    ]);
    echo "<script>
    window.location.href='/moha/agent/customer-orders.php';
    alert('Order successfully accepted!');
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
    <title>Agent | My orders</title>
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
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Requests</h3>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="nk-tb-list is-separate is-medium mb-3">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span>Order</span></div>
                                            <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                            <div class="nk-tb-col"><span class="d-none d-sm-block">Status</span></div>
                                            <div class="nk-tb-col tb-col-sm"><span>Customer</span></div>
                                            <div class="nk-tb-col tb-col-md"><span>Purchased</span></div>
                                            <div class="nk-tb-col"><span>Total</span></div>
                                            <div class="nk-tb-col"><span></span></div>
                                        </div><!-- .nk-tb-item -->
                                        <?php if ($requests['total'] == 0) : ?>
                                            <div class="nk-tb-col">
                                                <span>You have no requests in your area</span>
                                            </div>
                                        <?php else : ?>
                                            <?php foreach ($orders as $order) : ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col">
                                                        <span class="tb-lead"><a>#<?php echo $order['order_id'] ?></a></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub"><?php echo date("d/m/Y", strtotime($order['order_created_at']));  ?></span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <?php
                                                        if ($order['order_status'] == 'success') { ?>
                                                            <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex"><?php echo ucwords($order['order_status']) ?></span>
                                                        <?php } else if ($order['order_status'] == 'canceled') { ?>
                                                            <span class="badge badge-sm badge-dot has-bg bg-danger d-none d-sm-inline-flex"><?php echo ucwords($order['order_status']) ?></span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-sm badge-dot has-bg bg-warning d-none d-sm-inline-flex"><?php echo ucwords($order['order_status']) ?></span>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <span class="tb-sub"><?php echo ucwords($order['customer_name']) ?></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub text-primary"><?php echo $order['order_quantity'] ?? "" ?> Items</span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span class="tb-lead">$ <?php echo $order['order_amount'] ?? "" ?></span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">

                                                            <li>
                                                                <form method="post">
                                                                    <input name="id" value="<?php echo $order['order_id'] ?>" type="id" hidden required />
                                                                    <button type="submit" name="accept_order" class="btn btn-icon btn-trigger btn-tooltip" aria-label="Accept order" data-bs-original-title="Accept order" style="color:green;">

                                                                        <em class="icon ni ni-check"></em>
                                                                    </button>
                                                                </form>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!-- .nk-tb-item -->


                                    </div><!-- .nk-tb-list -->

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