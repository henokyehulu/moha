<?php
include_once("../config.php");
include_once("../src/needs_auth.php");

$stmt = $pdo->prepare("SELECT * FROM tbl_order where user=:id");
$stmt->execute([
    'id' => $user_id,
]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['mark_as_delivered'])) {
    $order_id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE tbl_order SET status=:status,agent_received=:agent_received WHERE id=:id");
    $stmt->execute([
        'status' => "success",
        'agent_received' => true,
        'id' => $order_id,
    ]);
    echo "<script>
            window.location.href='/moha/agent/index.php';
            alert('Thank you for purchasing products at moha!');
            </script>";
}

?>

<html lang="en">

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

            <table border="1">
                <thead>
                    <td>id</td>
                    <td>amount</td>
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
                                    if (!is_null($order['agent']) && $order['status'] != "success") {
                                        $stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
                                        $stmt->execute([$order['user']]);
                                        $agent = $stmt->fetch();

                                        echo "Your order is accepted by Agent: " . $agent['name'] . ". Please be patient. (STATUS: " . $order['status'] . ")";
                                    } else {
                                        echo $order['status'];
                                    }
                                    ?>
                                </td>
                                <td class="price">
                                    <?php
                                    if ($order['agent_delivered'] == true && $order['status'] != "success") { ?>
                                        <form method="post">
                                            <input name="id" value="<?php echo $order['id'] ?>" type="id" hidden required />
                                            <button name="mark_as_delivered">Mark as delivered</button>
                                        </form>
                                    <?php } ?>
                                    <?php
                                    if ($order['status'] == "success") { ?>
                                        <button>Download invoice</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
</body>

</html>