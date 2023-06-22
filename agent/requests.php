<?php
include_once("../config.php");
include_once("../src/needs_auth.php");

$stmt = $pdo->prepare("SELECT customer_order.id, (customer.name) AS customer_name,(customer.phone_number) AS customer_phone_number,customer_order.amount FROM customer_order INNER JOIN user AS customer ON customer_order.customer = customer.id  WHERE customer.state = ? AND customer_order.status = 'pending'");
$stmt->execute([$user_state]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
</head>

<body>
    <a href="/moha/agent/">back</a>
    <table border="1">
        <thead>
            <td>Order ID</td>
            <td>Customer</td>
            <td>Phone number</td>
            <td>Amount</td>
            <td>Action</td>
        </thead>
        <tbody>
            <?php if (empty($requests)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no request on your area yet.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($requests as $request) : ?>
                    <tr>
                        <td class="price"><?php echo $request['id'] ?></td>
                        <td class="price"><?php echo $request['customer_name'] ?></td>
                        <td class="price">
                            <a href="telto:<?php echo $request['customer_phone_number'] ?>">Call(<?php echo $request['customer_phone_number'] ?>)</a>
                        </td>
                        <td class="price">&dollar;<?php echo $request['amount'] ?></td>
                        <td class="price">
                            <a href="/moha/agent/request.php?order_id=<?php echo $request['id'] ?>">
                                <button>View order</button>
                            </a>
                            <!-- <form method="post">
                                <input name="id" value="<?php echo $request['id'] ?>" type="id" hidden required />
                                <button name="accept_request">Accept</button>
                            </form> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>