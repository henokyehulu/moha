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
<html lang="en">

<head>
    <title>Moha|Agent Dashboard </title>
    <?php include("../admin/partials/header.php"); ?>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../admin/partials/sidebar.php"); ?>
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <div class="nk-wrap ">
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">MY Orders</h3>
                                            <div class="nk-block-des text-soft">
                                            </div>
                                        </div><!-- .nk-block-head-content -->

                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card">
                                        <div class="card-inner-group">
                                            <div class="card-inner p-0">
                                                <div class="nk-tb-list">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <table class="table">

                                                            <thead>
                                                                <tr>
                                                                    <th>Customer</th>
                                                                    <th>Amount</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (empty($orders)) : ?>
                                                                    <tr>
                                                                        <td colspan="5" style="text-align:center;">You have no orders at the moment.</td>
                                                                    </tr>
                                                                <?php else : ?>
                                                                    <?php foreach ($orders as $order) : ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
                                                                                $stmt->execute([$order['user']]);
                                                                                $customer = $stmt->fetch();
                                                                                ?>

                                                                                <p><?php echo $customer['name'] ?></p>
                                                                            </td>
                                                                            <td class="price">&dollar;<?php echo $order['amount'] ?></td>
                                                                            <td class="price">
                                                                                <form method="post">
                                                                                    <input name="id" value="<?php echo $order['id'] ?>" hidden required />
                                                                                    <button name="accept_order" type="submit" class="btn btn-primary mt-3">Accept</button>
                                                                                </form>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <a href="./admin/accepted-order.php" class="btn btn-primary mt-3">Accepted order</a>
</body>

</html>