<?php
include_once "../config.php";
include_once "../src/needs_auth.php";


if (isset($_POST["addtostore"])) {
   $pid = $_POST['Pid'];
   $qty_prev = $_POST['qty_prev'];
   $qty = $_POST['qty'] + $qty_prev;
   $amount = $qty * 24;
   $update_product = $pdo->prepare("UPDATE `store` SET  quantity=? ,amount=?  WHERE id = ?");
   $update_product->execute([$qty, $amount, $pid]);
   echo "<script>
alert('Added successfully!');

window.location.href='/moha/admin/store.php';
</script>";
} else {
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
                                 <h3 class="nk-block-title page-title">Add to Store</h3>
                              </div><!-- .nk-block-head-content -->
                              <div class="nk-block-head-content">
                                 <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>

                                 </div>
                              </div><!-- .nk-block-head-content -->
                           </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <?php
                        $update_id = $_GET['add'];
                        $select_stores = $pdo->prepare("SELECT * FROM `store` WHERE id = ?");
                        $select_stores->execute([$update_id]);
                        if ($select_stores->rowCount() > 0) {
                           while ($fetch_stores = $select_stores->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                              <form action="" enctype="multipart/form-data" method="post">
                                 <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                       <div class="preview-block">
                                          <span class="preview-title-lg overline-title">Add to Store</span>
                                          <div class="row gy-4">
                                             <div class="col-sm-6">
                                                <div class="form-group">
                                                   <label class="form-label" for="default-01">Product Name</label>
                                                   <div class="form-control-wrap">
                                                      <label class="form-label" for="default-01"><?= $fetch_stores['name']; ?></label>

                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-sm-6">
                                                <div class="form-group">
                                                   <label class="form-label" for="default-textarea">Quantity</label>
                                                   <input type="hidden" name="Pid" value="<?= $fetch_stores['id']; ?>">
                                                   <input type="number" ass="box" maxlength="10" hidden name="qty_prev" value="<?= $fetch_stores['quantity']; ?>">


                                                   <input type="number" class="form-control" id="default-01" placeholder="" name="qty" value="">

                                                   <div class="form-control-wrap">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-sm-4">

                                                <div class="col-sm-4">
                                                   <div class="form-group">
                                                      <div class="form-control-wrap">
                                                         <div class="form-file">
                                                            <input type="submit" value="Add to store" class="btn" name="addtostore">

                                                         </div>
                                                      </div>
                              </form>
                        <?php
                           }
                        }
                        ?>
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