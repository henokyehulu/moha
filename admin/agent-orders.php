<?php
include_once("../config.php");
include_once("../src/needs_auth.php");

$stmt = $pdo->prepare("SELECT agent_order.id, agent_order.amount, agent_order.status, (agent.name) AS customer_name, (agent.phone_number) AS customer_phone_number FROM agent_order INNER JOIN user AS agent ON agent_order.agent = agent.id ");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (isset($_POST['mark_as_delivered'])) {
    $order_id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE agent_order SET status=:status,agent_delivered=:agent_delivered, agent=:agent_id WHERE id=:order_id");
    $stmt->execute([
        'status' => "agent_delivered",
        'agent_delivered' => true,
        'agent_id' => $user_id,
        'order_id' => $order_id
    ]);
    echo "<script>
    window.location.href='/moha/agent/agent-orders.php';
    alert('Thank you for delivering order to agent!');
    </script>";
}

if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE agent_order SET status=:status, agent_delivered=:agent_delivered, agent=:agent_id WHERE id=:order_id");
    $stmt->execute([
        'status' => "pending",
        'agent_delivered' => false,
        'agent_id' => null,
        'order_id' => $order_id
    ]);
    echo "<script>
        window.location.href='/moha/agent/agent-orders.php';
        alert('Order successfully canceled!');
        </script>";
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer orders</title>
</head>

<body>
    <a href="/moha/agent/">back</a>
    <table border="1">
        <thead>
            <td>id</td>
            <td>agent</td>
            <td>phone number</td>
            <td>amount</td>

            <td>status</td>
            <!-- <td>action</td> -->
        </thead>
        <tbody>
            <?php if (empty($orders)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no orders yet.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td class="price"><?php echo $order['id'] ?></td>
                        <td class="price"><?php echo $order['customer_name'] ?></td>
                        <td class="price">
                            <a href="telto:<?php echo $order['customer_phone_number'] ?>">Call (<?php echo $order['customer_phone_number'] ?>)</a>
                        </td>
                        <td class="price">&dollar;<?php echo $order['amount'] ?></td>
                        <td class="price"><?php echo $order['status'] ?></td>
                        <!-- <td class="price">
                            <?php
                            if ($order['status'] == "agent_accepted") { ?>
                                <form method="post">
                                    <input name="id" value="<?php echo $order['id'] ?>" type="id" hidden required />
                                    <button name="mark_as_delivered">Mark as delivered</button>
                                </form>
                            <?php }
                            ?>
                            <?php
                            if ($order['status'] == "agent_accepted") { ?>
                                <form method="post">
                                    <input name="id" value="<?php echo $order['id'] ?>" type="id" hidden required />
                                    <button name="cancel_order">Cancel order</button>
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