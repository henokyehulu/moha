<?php
include_once("../config.php");
include_once("../src/needs_auth.php");

$stmt = $pdo->prepare("SELECT * FROM agent_order where agent=:id");
$stmt->execute([
    'id' => $user_id,
]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['mark_as_delivered'])) {
    $order_id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE agent_order SET status=:status WHERE agent=:agent_id");
    $stmt->execute([
        'status' => "delivered",
        'agent_id' => $user_id
    ]);
    header("location:/moha/agent/my-orders.php");
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
    <a href="/moha/agent/">back</a>
    <table border="1">
        <thead>
            <td>id</td>
            <td>amount</td>
            <td>status</td>
            <!-- <td>action</td> -->
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
                        <td class="price"><?php echo $order['status'] ?></td>
                        <!-- <td class="price">
                            <?php
                            if ($order['status'] == "delivered") { ?>
                                <p>Delivered!</p>
                            <?php } else { ?>

                                <form method="post">
                                    <input name="id" value="<?php echo $order['id'] ?>" type="id" hidden required />
                                    <button name="mark_as_delivered">Mark as delivered</button>
                                </form>
                            <?php }
                            ?>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>