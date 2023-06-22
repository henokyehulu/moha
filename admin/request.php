<?php
include_once("../config.php");
include_once("../src/needs_auth.php");


$order_id = $_REQUEST['order_id'];

$stmt = $pdo->prepare("SELECT * FROM agent_order WHERE id=? AND status = 'pending'");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$order){
    echo "<script>
    window.location.href='/moha/admin/requests.php';
    alert('The order does not exist!');
    </script>";
}
$stmt = $pdo->prepare("SELECT user.state FROM agent_order INNER JOIN user WHERE agent_order.id=?");
$stmt->execute([$order_id]);
$agent = $stmt->fetch(PDO::FETCH_ASSOC);

if($user_state != $agent['state']){
    echo "<script>
    window.location.href='/moha/admin/requests.php';
    alert('This order is not available in your area!');
    </script>";
}

$stmt = $pdo->prepare("SELECT * FROM orderandproduct_agent INNER JOIN product ON product.id = orderandproduct_agent.product_id WHERE orderandproduct_agent.order_id=?");
$stmt->execute([$order_id]);
$order_list = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['accept_request'])) {
    $stmt = $pdo->prepare("UPDATE agent_order SET status=:status WHERE id=:order_id");
    $stmt->execute([
        'status' => "company_accepted",
        'order_id' => $order_id
    ]);
    echo "<script>
    window.location.href='/moha/admin/agent-orders.php';
    alert('Order accepted successfully!');
    </script>";
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View request</title>
</head>
<body>
    <a href="/moha/admin/requests.php">back</a>

    <p>Order:</p>
    <table>
        <tbody>
          
                <?php foreach ($order_list as $order) : ?>
                    <tr>
                        <td>
                            <p> x<?php echo $order['quantity'] . " " . $order['name'] ?> creat</p>
                        </td>
                        <!-- <td class="price">&dollar;<?php echo $product['price'] * $products_in_cart[$product['id']] * 24 ?></td> -->

                    </tr>
                <?php endforeach; ?>
           
        </tbody>
        <tfoot>
            <!-- <tr>
                <td class="text" colspan="5">Subtotal</td>
                <td style="text-align: end;" colspan="3" class="price">
                    &dollar;<?php echo $subtotal ?>
                </td>
            </tr>
            <tr>
                <td class="text" colspan="5">Total</td>
                <td style="text-align: end;" colspan="3" class="price">
                    &dollar;<?php echo $total ?>
                </td>
            </tr>
        -->
        
        <form method="post">
            <button name="accept_request" type="submit">Accept order</button>
        </form>

        </tfoot> 
    </table>
   
</body>
</html>