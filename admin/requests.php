<?php
require_once "../src/needs_auth.php";
require_once "../config.php";

$stmt = $pdo->prepare("SELECT agent_order.id, (agent.name) AS agent_name,(agent.phone_number) AS agent_phone_number,agent_order.amount FROM agent_order INNER JOIN user AS agent ON agent_order.agent = agent.id  WHERE agent.state = ? AND agent_order.status = 'pending'");
$stmt->execute([$user_state]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST["addrequest"])) {
    $Pname = $_POST['Pname'];
    $Price = $_POST['Price'];
    $desc = $_POST['desc'];
    $Pimage = $_FILES['Pimage']['name'];
    $Pimage_tmp_name = $_FILES['Pimage']['tmp_name'];
    $Pimagefolder = 'uploadrequest/' . $Pimage;

    $stmt = $pdo->prepare("SELECT * FROM request WHERE name=:Pname");
    $stmt->execute([
        'Pname' => $Pname,
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        $stmt = $pdo->prepare("INSERT INTO request(name,price,description,image)VALUES(:Pname,:Price,:desc,:Pimage)");
        $stmt->execute([
            'Pname' => $Pname,
            'Price' => $Price,
            'desc' => $desc,
            'Pimage' => $Pimage,

        ]);
        $stmt = $pdo->prepare("INSERT INTO store(name)VALUES(:Pname)");
        $stmt->execute([
            'Pname' => $Pname,

        ]);

        move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
        $message[] = "add successfully";
        header("location:../admin/index.php");
    } else {
        echo "Product Name is already exist.";
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_request_image = $pdo->prepare("SELECT image FROM `request` WHERE id = ?");
    $delete_request_image->execute([$delete_id]);
    $fetch_delete_image = $delete_request_image->fetch(PDO::FETCH_ASSOC);
    //unlink('../uploadrequest/' . $fetch_delete_image['image']);
    $delete_request = $pdo->prepare("DELETE FROM `request` WHERE id = ?");
    $delete_request->execute([$delete_id]);
    //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    //$delete_cart->execute([$delete_id]);
    echo "<script>
  window.location.href='admin/ManageProduct.php';
  alert('Product Deleted successfully!');
  </script>";
}
if (isset($_POST["postad"])) {
    $Pname = $_POST['Pname'];
    $Price = $_POST['Price'];
    $avq = $_POST['avq'];
    $desc = $_POST['desc'];
    $Pimage = $_FILES['Pimage']['name'];
    $Pimage_tmp_name = $_FILES['Pimage']['tmp_name'];
    $Pimagefolder = '../uploadsad/' . $Pimage;



    $stmt = $pdo->prepare("INSERT INTO Ad(name,price,description,image)VALUES(:Pname,:Price,:desc,:Pimage)");
    $stmt->execute([
        'Pname' => $Pname,
        'Price' => $Price,
        'desc' => $desc,
        'Pimage' => $Pimage,

    ]);
    if ($stmt) {
        move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
        $message[] = "add successfully";
        header("location:../admin/index.php");
    } else {
        $message[] = "could not add the request ";
    }
}
if (isset($_GET['delete'])) {
    $delete_request_image = $pdo->prepare("SELECT image FROM `ad` WHERE id = ?");
    $delete_request_image->execute([$delete_id]);
    $fetch_delete_image = $delete_request_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploadrequest/' . $fetch_delete_image['image']);
    $delete_request = $pdo->prepare("DELETE FROM `ad` WHERE id = ?");
    $delete_request->execute([$delete_id]);
    //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    //$delete_cart->execute([$delete_id]);
    header("location:/admin/ManageProduct.php");
}


?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Admin | My orders</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <?php include_once "../admin/lib/sidebar.php" ?>
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <?php include_once "../admin/lib/header.php" ?>

                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Products</h3>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>

                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="card">
                                    <div class="card-inner-group">
                                        <div class="card-inner p-0">
                                            <div class="nk-tb-list">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col tb-col-sm"><span>ID</span></div>
                                                    <div class="nk-tb-col tb-col-sm"><span>Agent Name</span></div>

                                                    <div class="nk-tb-col tb-col-sm"><span>Phone Number</span></div>
                                                    <div class="nk-tb-col"><span>Total</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>Action</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span></span></div>
                                                </div>
                                                <?php foreach ($requests as $request) : ?>
                                                    <!-- .nk-tb-item -->
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <span class="tb-request">
                                                                <span class="title"><?php echo $request['id'] ?></span>
                                                            </span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><?php echo $request['agent_name'] ?></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub"><?php echo $request['agent_phone_number'] ?></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub"><?php echo $request['amount'] ?></span>
                                                        </div>


                                                        <a href="admin/request.php?order_id=<?php echo $request['id'] ?>">
                                                            <button class="btn btn-primary mt-3">View order</button>
                                                        </a>

                                                    </div>
                                                    <!-- .nk-tb-item -->

                                                <?php endforeach; ?>

                                            </div><!-- .nk-tb-list -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content @e -->
                    <!-- footer @s -->
                    <?php include_once "./lib/footer.php" ?>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
        <script src="./assets/js/bundle.js?ver=3.1.3"></script>
        <script src="./assets/js/scripts.js?ver=3.1.3"></script>
        <script src="./assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>