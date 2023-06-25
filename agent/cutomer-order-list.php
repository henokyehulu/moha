<?php
include_once("../config.php");
include_once("../src/needs_auth.php");
$stmt = $pdo->prepare("SELECT * FROM tbl_order WHERE status='pending'");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_keys($products_in_cart));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']] * 24;
    }
}

if (isset($_POST['accept_order'])) {
    $stmt = $pdo->prepare("UPDATE tbl_order SET status=:status, agent=:agentid where id=:id");
    $stmt->execute(
        [
            "status" => "agent_accepted",
            "agentid" => $_SESSION['id'],
            "id" => $_POST['id']
        ],
    );
    echo "<script>
            window.location.href='/moha/admin/index.php';
            alert('Order accepeted successfully!');
            </script>";
}


?>
<!DOCTYPE html>
<html lang="zxx" class="js">

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
            <!-- main header @s -->
            <?php include("../agent/partials/sidebar.php"); ?>
            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title"> Customer orders</h3>
                                        <div class="nk-block-des text-soft">
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                            <div class="toggle-expand-content" data-content="more-options">
                                                <ul class="nk-block-tools g-3">
                                                    <li>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni ni-search"></em>
                                                            </div>
                                                            <input type="text" class="form-control" id="default-04" placeholder="Search by name">
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle dropdown-indicator btn btn-outline-light btn-white" data-bs-toggle="dropdown">Status</a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><span>Actived</span></a></li>
                                                                    <li><a href="#"><span>Inactived</span></a></li>
                                                                    <li><a href="#"><span>Blocked</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li><!-- data-item -->
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-tb-list is-separate mb-3">
                                    <div class="nk-tb-item nk-tb-head">

                                        <div class="nk-tb-col"><span class="sub-text">Customer Name </span></div>
                                        <div class="nk-tb-col tb-col-mb"><span class="sub-text">Price</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Phone No</span></div>
                                        <div class="nk-tb-col tb-col-lg"><span class="sub-text">Address</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                                        <div class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1 my-n1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-mail"></em><span>Send Email to All</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend Selected</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-trash"></em><span>Remove Seleted</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Password</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- .nk-tb-item -->
                                    <?php if (empty($orders)) : ?>

                                        <p colspan="5" style="text-align:center;">You have no orders at the moment.</p>

                                    <?php else : ?>
                                        <?php foreach ($orders as $order) : ?>
                                            <div class="nk-tb-item">

                                                <div class="nk-tb-col">
                                                    <a href="html/ecommerce/customer-details.html">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead">
                                                                    <?php
                                                                    $stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
                                                                    $stmt->execute([$order['user']]);
                                                                    $customer = $stmt->fetch();
                                                                    ?>

                                                                    <p><?php echo $customer['name'] ?></p> <span class="dot dot-success d-md-none ms-1"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="nk-tb-col tb-col-mb">
                                                    <span class="price">&dollar;<?php echo $order['amount'] ?> <span class="currency"></span></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span><?php
                                                            $stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
                                                            $stmt->execute([$order['user']]);
                                                            $customer = $stmt->fetch();
                                                            ?>

                                                        <p><?php echo $customer['phone_number'] ?></p> <span class="dot dot-success d-md-none ms-1"></span>
                                                    </span></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-lg">
                                                    <span>United State</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-status text-success">
                                                        <form method="post">
                                                            <input name="id" value="<?php echo $order['id'] ?>" hidden required />
                                                            <button name="accept_order" type="submit" class="btn btn-primary mt-3">Accept</button>
                                                        </form>
                                                    </span>
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">

                                                        <li class="nk-tb-action-hidden">

                                                            <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                                                <em class="icon ni ni-eye"></em>
                                                            </a>
                                                        </li>
                                                        <li class="nk-tb-action-hidden">
                                                            <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                                                <em class="icon ni ni-user-cross-fill"></em>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="html/customer-details.html"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-repeat"></em><span>Orders</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div><!-- .nk-tb-item --> <?php endforeach; ?>
                                    <?php endif; ?>
                                </div><!-- .nk-tb-list -->
                                <a href="./agent/accepted-order.php" class="btn btn-primary mt-3">Accepted order</a>
                                <div class="card">
                                    <div class="card-inner">
                                        <div class="nk-block-between-md g-3">
                                            <div class="g">
                                                <ul class="pagination justify-content-center justify-content-md-start">
                                                    <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                    <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                                </ul><!-- .pagination -->
                                            </div>
                                        </div><!-- .pagination-goto -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .card-inner -->
                            </div><!-- .card -->
                        </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
        <!-- footer @s -->
        <?php include("../agent/partials/footer.php"); ?>
        <!-- footer @e -->
        <!-- JavaScript -->



        <script src="./assets/js/bundle.js?ver=3.1.3"></script>
        <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>