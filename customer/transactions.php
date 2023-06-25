<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT customer_order.id,customer_order.created_at,customer_order.amount,customer_order.status,agent.name AS agent_name,SUM(orderandproduct_customer.quantity) AS quantity FROM orderandproduct_customer INNER JOIN customer_order ON customer_order.id = orderandproduct_customer.order_id LEFT JOIN user AS agent ON customer_order.agent = agent.id WHERE customer_order.customer = ? AND customer_order.status IN ('success', 'canceled')  GROUP BY orderandproduct_customer.order_id ORDER BY customer_order.created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['mark_as_received'])) {
    $order_id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE customer_order SET status=:status,customer_received=:customer_received WHERE id=:order_id");
    $stmt->execute([
        'status' => "success",
        'customer_received' => true,
        'order_id' => $order_id
    ]);
    header("location:/moha/customer/my-orders.php");
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
    <title>Customer | Transactions</title>
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
                                            <h3 class="nk-block-title page-title">Transactions</h3>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="nk-tb-list is-separate is-medium mb-3">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span>Order</span></div>
                                            <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                            <div class="nk-tb-col"><span class="d-none d-sm-block">Status</span></div>
                                            <div class="nk-tb-col tb-col-sm"><span>Agent</span></div>
                                            <div class="nk-tb-col tb-col-md"><span>Purchased</span></div>
                                            <div class="nk-tb-col"><span>Total</span></div>
                                            <div class="nk-tb-col"><span></span></div>
                                        </div><!-- .nk-tb-item -->
                                        <?php if (empty($orders)) : ?>
                                            <div class="nk-tb-col">
                                                <span>You have no orders made yet</span>
                                            </div>
                                        <?php else : ?>
                                            <?php foreach ($orders as $order) : ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col">
                                                        <span class="tb-lead"><a>#<?php echo $order['id'] ?></a></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub"><?php echo date("d/m/Y", strtotime($order['created_at']));  ?></span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <?php
                                                        if ($order['status'] == 'success') { ?>
                                                            <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex"><?php echo ucwords($order['status']) ?></span>
                                                        <?php } else if ($order['status'] == 'canceled') { ?>
                                                            <span class="badge badge-sm badge-dot has-bg bg-danger d-none d-sm-inline-flex"><?php echo ucwords($order['status']) ?></span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-sm badge-dot has-bg bg-warning d-none d-sm-inline-flex"><?php echo ucwords($order['status']) ?></span>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <span class="tb-sub"><?php echo ucwords($order['agent_name']) ?></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub text-primary"><?php echo $order['quantity'] ?> Items</span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span class="tb-lead">$ <?php echo $order['amount'] ?></span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <?php
                                                            if ($order['status'] == 'agent_delivered') { ?>
                                                                <li>
                                                                    <form method="post">
                                                                        <input name="id" value="<?php echo $order['id'] ?>" type="id" hidden required />
                                                                        <button type="submit" name="mark_as_received" class="btn btn-icon btn-trigger btn-tooltip" aria-label="Mark as Delivered" data-bs-original-title="Mark as received">

                                                                            <em class="icon ni ni-truck"></em>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            <?php }
                                                            ?>
                                                            <?php
                                                            if ($order['status'] == 'success') { ?>
                                                                <li>
                                                                    <a href="/moha/customer/invoice.php?id=<?php echo $order['id'] ?>" class="btn btn-icon btn-trigger btn-tooltip" aria-label="View Invoice" data-bs-original-title="View Invoice">
                                                                        <em class="icon ni ni-eye"></em>
                                                                    </a>
                                                                </li>
                                                            <?php }
                                                            ?>

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