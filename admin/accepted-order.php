<?php
include_once("../config.php");
include_once("../src/needs_auth.php");
$stmt = $pdo->prepare("SELECT * FROM tbl_order WHERE status='agent_accepted' and agent=:agentid");
$stmt->execute(
    [
        "agentid" => $_SESSION['id'],
    ]
);
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

if (isset($_POST['deliver_order'])) {
    $stmt = $pdo->prepare("UPDATE tbl_order SET status=:status, agent_delivered=:agent_delivered where id=:id");
    $stmt->execute(
        [
            "status" => "agent_delivered",
            "agent_delivered" => true,
            "id" => $_POST['id']
        ],
    );
    echo "<script>
            window.location.href='/moha/admin/index.php';
            alert('Order delivered successfully!');
            </script>";
}


?>
<html lang="en">

<head>
    <title>Moha|Admin Dashboard </title>
    <?php include("../admin/partials/header.php"); ?>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../admin/partials/sidebar.php"); ?>
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <h1>Orders</h1>
            <table border="1">
                <thead>
                    <td>Customer</td>
                    <td>Amount</td>
                    <td>Action</td>
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
                                        <button name="deliver_order" type="submit">Mark as deliver</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
</body>

</html>