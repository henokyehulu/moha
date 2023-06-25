<?php
if (isset($_POST['purchase'])) {
    $stmt = $pdo->prepare("INSERT INTO tbl_order (user, amount) VALUES(:user, :amount)");
    $stmt->execute([
        'user' => intval($user_id),
        'amount' => $total,
    ]);

    $_SESSION['cart'] = [];

    echo "<script>
        window.location.href='/moha/agent/email.php';
        alert('Order successfully placed!');
        </script>";
}


?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <title>Cart </title>
    <?php include("../agent/partials/header.php");
    session_start();
    ?>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../agent/partials/sidebar.php"); ?>

        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php include("../agent/partials/sidebar.php"); ?>
            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title"> My Cart</h3>
                                        <div class="nk-block-des text-soft">
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                            <div class="toggle-expand-content" data-content="more-options">
                                                <ul class="nk-block-tools g-3">
                                                    <li>
                                                        <div class="nk-block-head-sub"><a class="back-to" href="agent/orders-default.php"><em class="icon ni ni-arrow-left"></em><span>back</span></a></div>
                                                    </li>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center border rounded bg-light my-5">
                                    <h1>MY CART</h1>
                                </div>
                                <div class="col-lg-9">
                                    <table class="table">
                                        <thead class="text-cnter">
                                            <tr>
                                                <th scope="col">Order NO</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Item Price</th>
                                                <th scope="col">Caset</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-cnter">
                                            <?php
                                            $i = 0;
                                            if (isset($_SESSION['cart'])) {
                                                foreach ($_SESSION['cart'] as $key => $value) {

                                                    $i++;
                                                    echo "
                           <tr>
                           <td>$i</td>
                           <td>$value[Item_Name]</td>
                           <td>$value[Price]<input type= 'hidden'  class='iprice' value='$value[Price]'></td>
                           <td style='width: 20%;'>
                           <form action='agent/manage_cart.php' method='POST'>
                               <input class='form-control form-control-sm number-spinner iquantity'name='Mod_Quantity' onchange='this.form.submit();' type='number' value='$value[Quantity]'  min='1' ></td>
                               <input type='hidden' name='Item_Name' value='$value[Item_Name]'>
                               </form>
                           <td class='itotal'></td>
                           <td>
                           <form action='agent/manage_cart.php' method='POST'>
                           <button  name='Remove_Item' class='btn  btn-sm btn-outline-danger'>Remove</button>
                           <input type='hidden' name='Item_Name' value='$value[Item_Name]'>
                           </form>
                           </td>
                           </tr>
                           ";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-3">
                                    <div class="border bg-light rounded p-4">
                                        <h4>Grand Total:</h4>
                                        <br>
                                        <h5 id="gtotal"></h5>
                                        <br>
                                        <?php
                                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {


                                        ?>
                                            <form method="POST">
                                                <div class="tb-odr-btns d-none d-sm-inline">
                                                    <a name="purchase" class="btn btn-dim btn-sm btn-primary"><button>Purchase</button></a>
                                                    <a href="agent/checkout.php" class="btn btn-dim btn-sm btn-primary" name="purchase">View</a>
                                                </div>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- JavaScript -->


                        <script>
                            var gt = 0;
                            var iprice = document.getElementsByClassName('iprice');
                            var iquantity = document.getElementsByClassName('iquantity');
                            var itotal = document.getElementsByClassName('itotal');
                            var gtotal = document.getElementById('gtotal');

                            function subTotal() {
                                gt = 0;
                                for (i = 0; i < iprice.length; i++) {
                                    itotal[i].innerText = (iprice[i].value) * (iquantity[i].value) * (24);

                                    gt = gt + (iprice[i].value) * (iquantity[i].value) * (24);
                                }
                                gtotal.innerText = gt;
                            }
                            subTotal();
                        </script>
                        <script src="./assets/js/bundle.js?ver=3.1.3"></script>
                        <script src="./assets/js/scripts.js?ver=3.1.3"></script>
                        <?php include("../agent/partials/footer.php"); ?>
</body>

</html>