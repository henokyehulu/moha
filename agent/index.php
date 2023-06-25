<?php
include_once "../config.php";
include_once "../src/needs_auth.php";



$stmt = $pdo->prepare("SELECT COUNT(amount) AS total FROM agent_order WHERE agent = ? AND status NOT IN ('success','canceled')");
$stmt->execute([$user_id]);
$pending_orders = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT SUM(amount) AS total FROM agent_order WHERE status != 'canceled' AND agent = ?");
$stmt->execute([$user_id]);
$total_spent = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT SUM(orderandproduct_agent.quantity) AS total FROM agent_order INNER JOIN orderandproduct_agent ON agent_order.id = orderandproduct_agent.order_id WHERE status != 'canceled' AND agent_order.agent = ? ");
$stmt->execute([$user_id]);
$total_products_bought = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT agent_order.id,agent_order.created_at,agent_order.amount,agent_order.status FROM agent_order LEFT JOIN user AS agent ON agent_order.agent = agent.id WHERE agent_order.agent = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT COUNT(id) AS total FROM agent_vehicles WHERE owner = ?");
$stmt->execute([$user_id]);
$total_vehicles = $stmt->fetch(PDO::FETCH_ASSOC);



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
    <title>Agent | Dashboard</title>
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
                                            <h3 class="nk-block-title page-title">Dashboard</h3>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li class="nk-block-tools-opt"><a href="/moha/agent/order.php" class="btn btn-primary"><em class="icon ni ni-cart"></em><span>Order</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <a href="/moha/agent/my-orders.php" class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Total Orders</h6>
                                                            </div>
                                                        </a>
                                                        <div class="data">
                                                            <div class="data-group">
                                                                <div class="amount"><?php echo $pending_orders['total'] ?? 0 ?></div>
                                                            </div>

                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <a href="/moha/agent/transactions.php" class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Total Spent</h6>
                                                            </div>
                                                        </a>
                                                        <div class="data">
                                                            <div class="data-group">
                                                                <div class="amount">$<?php echo number_format((float)$total_spent['total'] ?? 0, 2, '.', ''); ?></div>
                                                            </div>

                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <a class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Total products bought</h6>
                                                            </div>
                                                        </a>
                                                        <div class="data">
                                                            <div class="data-group">
                                                                <div class="amount"><?php echo $total_products_bought['total'] ?? 0 ?></div>
                                                            </div>

                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->


                                        <!-- .col -->
                                        <div class="col-xxl-8">
                                            <div class="card card-full">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">Recent Orders</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-list mt-n2">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col"><span>Order No.</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                        <div class="nk-tb-col"><span>Amount</span></div>
                                                        <div class="nk-tb-col"><span class="d-none d-sm-inline">Status</span></div>
                                                    </div>
                                                    <?php if (empty($recent_orders)) : ?>
                                                        <div class="nk-tb-col">
                                                            <span>You have no orders made yet</span>
                                                        </div>
                                                    <?php else : ?>
                                                        <?php foreach ($recent_orders as $order) : ?>
                                                            <div class="nk-tb-item">
                                                                <div class="nk-tb-col">
                                                                    <span class="tb-lead"><a>#<?php echo $order['id'] ?></a></span>
                                                                </div>
                                                                <div class="nk-tb-col tb-col-md">
                                                                    <span class="tb-sub"><?php echo date("d/m/Y", strtotime($order['created_at']));  ?></span>
                                                                </div>
                                                                <div class="nk-tb-col">
                                                                    <span class="tb-sub tb-amount"><?php echo $order['amount'] ?> <span>Birr</span></span>
                                                                </div>
                                                                <div class="nk-tb-col">
                                                                    <?php
                                                                    if ($order['status'] == 'success') { ?>
                                                                        <span class="badge badge-dot badge-dot-xs bg-success"><?php echo ucwords($order['status']) ?></span>
                                                                    <?php } else if ($order['status'] == 'canceled') { ?>
                                                                        <span class="badge badge-dot badge-dot-xs bg-danger"><?php echo ucwords($order['status']) ?></span>
                                                                    <?php } else { ?>
                                                                        <span class="badge badge-dot badge-dot-xs bg-warning"><?php echo ucwords($order['status']) ?></span>
                                                                    <?php }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div><!-- .card -->
                                        </div>
                                    </div><!-- .row -->
                                </div><!-- .nk-block -->
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