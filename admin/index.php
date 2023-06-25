<?php
require_once "../config.php";
require_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT COUNT(amount) AS total FROM customer_order");
$stmt->execute();
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC);



$stmt = $pdo->prepare("SELECT COUNT(amount) AS total FROM agent_order");
$stmt->execute();
$total_agent_order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT COUNT(name) AS total FROM store");
$stmt->execute();
$store = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT SUM(orderandproduct_customer.quantity) AS total FROM customer_order INNER JOIN orderandproduct_customer ON customer_order.id = orderandproduct_customer.order_id WHERE customer_order.customer = ?");
$stmt->execute([$user_id]);
$total_products_bought = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT customer_order.id,customer_order.created_at,customer_order.amount,customer_order.status,agent.name as customer_name FROM customer_order LEFT JOIN user AS agent ON customer_order.agent = agent.id WHERE customer_order.customer = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zxx" class="js">
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
    <title>Admin | Dashboard</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../admin/lib/sidebar.php"); ?>

        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php include("../admin/lib/header.php"); ?>
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

                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">Total Customer Orders</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount"><?php echo $total_orders['total'] ?? 0 ?></div>
                                                            <div class="nk-ecwg6-ck">
                                                            </div>
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
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title"> Total Agent vehicles</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount"><?php echo $agent_vehicles['total'] ?? 0 ?></div>
                                                            <div class="nk-ecwg6-ck">
                                                            </div>
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
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">Total Agent Order</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount"><?php echo $total_agent_order['total'] ?? 0 ?></div>
                                                            <div class="nk-ecwg6-ck">
                                                            </div>
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
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">Product in store</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount"><?php echo $store['total'] ?? 0 ?></div>
                                                            <div class="nk-ecwg6-ck">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->

                                </div><!-- .row -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer @s -->
            <?php include("../agent/lib/footer.php"); ?>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
    </div>

    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
    <script src="./assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>