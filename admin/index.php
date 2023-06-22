<?php
require_once "../src/needs_auth.php";
require_once "../config.php";
$stmt = $pdo->prepare("SELECT 
agent_order.id,COUNT(agent_order.id) AS total, (agent.name) AS agent_name FROM agent_order INNER JOIN user AS agent ON agent_order.agent = agent.id  WHERE agent.state = ? AND agent_order.status = 'pending'");
$stmt->execute([$user_state]);
$requests = $stmt->fetch(PDO::FETCH_ASSOC);

  


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <title>Home</title>

</head>

<body>
    <p>Hello big <strong><?php  echo $_SESSION['name'] ?></strong>. Here you go</p>
    <pre>
        id: <?php  echo $_SESSION['id'] ?>,
        name: <?php  echo $_SESSION['name'] ?>,
        role: <?php  echo $_SESSION['role'] ?>,
        session expires on: <?php  echo date('m/d/Y H:i:s', $_SESSION['expires_at']) ." (". date("H:i:s",$_SESSION['expires_at'] - time())  ." left)"; ?>

    </pre>    <a href="/moha/admin/agent-orders.php">Orders</a>
    </pre>    <a href="/moha/admin/Product.php">Product</a>
    </pre>    <a href="/moha/admin/agent-orders.php">Agent Orders</a>

    </pre>    <a href="/moha/admin/store.php">Store</a>
        </pre>    <a href="/moha/admin/ManageAgent.php">Manage User</a>
        <a href="/moha/admin/requests.php">Requests(<?php echo $requests['total'] ?? "0" ?>)</a>


 
 
 
 </div>
 
    <a href="../src/logout.php">Logout</a>
</body>

</html>