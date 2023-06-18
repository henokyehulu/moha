<?php
require_once "../config.php";
require_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT 
customer_order.id,COUNT(customer_order.id) AS total, (customer.name) AS customer_name FROM customer_order INNER JOIN user AS customer ON customer_order.customer = customer.id  WHERE customer.state = ? AND customer_order.status = 'pending'");
$stmt->execute([$user_state]);
$requests = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <p>Hello big 🍆 <strong><?php echo $user_name ?></strong>.</p>
    <a href="/moha/agent/requests.php">Requests(<?php echo $requests['total'] ?? "0" ?>)</a>
    <a href="/moha/agent/order.php">Order</a>
    <a href="/moha/agent/customer-orders.php">Customer orders</a>
    <a href="/moha/agent/my-orders.php">My orders</a>
    <a href="/moha/agent/profile.php">Profile</a>
    <a href="/moha/src/logout.php">Logout</a>
</body>

</html>