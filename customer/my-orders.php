<?php
include_once("../config.php");
include_once("../src/needs_auth.php");

$stmt = $pdo->prepare("SELECT * FROM customer_order WHERE customer_order.customer = ?");
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

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My orders</title>
</head>

<body>
    <a href="/moha/customer/">back</a>
    <table border="1">
        <thead>
            <td>id</td>
            <td>amount</td>
            <td>agent</td>
            <td>phone number</td>
            <td>status</td>
            <td>action</td>
        </thead>
        <tbody>
            <?php if (empty($orders)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no orderes placed yet.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td class="price"><?php echo $order['id'] ?></td>
                        <td class="price">&dollar;<?php echo $order['amount'] ?></td>
                        <td class="price">
                            <?php
                            $stmt = $pdo->prepare("SELECT * from user WHERE id=?");
                            $stmt->execute([$order['agent']]);
                            $agent = $stmt->fetch(PDO::FETCH_ASSOC);
                            if (!is_null($order['agent'])) {
                                echo $agent['name'];
                            } else {
                                echo "-:-";
                            } ?>
                        </td>
                        <td class="price">
                            <?php
                            $stmt = $pdo->prepare("SELECT * from user WHERE id=?");
                            $stmt->execute([$order['agent']]);
                            $agent = $stmt->fetch(PDO::FETCH_ASSOC);
                            if (!is_null($order['agent'])) { ?>
                                <a href="telto:<?php echo $agent['phone_number']; ?>">Call (<?php echo $agent['phone_number']; ?>)</a>
                            <?php } else { ?>
                                <span>-:-</span>
                            <?php } ?>
                        </td>
                        <td class="price"><?php echo $order['status'] ?></td>
                        <td class="price">
                            <?php
                            if ($order['agent_delivered'] == true && $order['customer_received'] == false) { ?>
                                <form method="post">
                                    <input name="id" value="<?php echo $order['id'] ?>" type="id" hidden required />
                                    <button name="mark_as_received">Mark as received</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>