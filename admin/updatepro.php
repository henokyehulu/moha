<?php
include_once "../config.php";
include_once "../src/needs_auth.php";


if (isset($_POST["update_prod"])) {
   $pid = $_POST['Pid'];
   $Pname = $_POST['Pname'];
   $desc = $_POST['desc'];
   $old_image = $_POST['old_image'];
   $Pimage = $_FILES['Pimage']['name'];
   $Pimage_size = $_FILES['Pimage']['size'];
   $Pimage_tmp_name = $_FILES['Pimage']['tmp_name'];
   $Pimagefolder = '../uploadproduct/' . $Pimage;

   $update_product = $pdo->prepare("UPDATE `product` SET name = ?, description=? WHERE id = ?");
   $update_product->execute([$Pname,  $desc, $pid]);
   $message[] = 'product updated successfully!';



   if (!empty($Pimage)) {
      if ($Pimage_size > 2000000) {
         $message[] = 'image size is too large!';
      } else {
         $update_image = $pdo->prepare("UPDATE `product` SET image =:Pimage WHERE id =:id");
         $update_image->execute([
            'Pimage' => 'uploadproduct/' . $Pimage,
            'id' => $pid
         ]);
         move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
         unlink('../uploadproduct' . $old_image);
         echo "<script>
         window.location.href='/moha/admin/ManageProduct.php';
         alert('Updated successfully!');
         </script>";
      }
   }
} else {
   echo "Product Name is already exist.";
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
                                 <h3 class="nk-block-title page-title">Update Product</h3>
                              </div><!-- .nk-block-head-content -->
                              <div class="nk-block-head-content">
                                 <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>

                                 </div>
                              </div><!-- .nk-block-head-content -->
                           </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <?php
                        $update_id = $_GET['update'];
                        $select_products = $pdo->prepare("SELECT * FROM `product` WHERE id = ?");
                        $select_products->execute([$update_id]);
                        if ($select_products->rowCount() > 0) {
                           while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                              <form action="" enctype="multipart/form-data" method="post">
                                 <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                       <div class="preview-block">
                                          <span class="preview-title-lg overline-title">Update Prodcut</span>
                                          <div class="row gy-4">
                                             <div class="col-sm-6">
                                                <div class="form-group">
                                                   <label class="form-label" for="default-01">Input text Default</label>
                                                   <div class="form-control-wrap">
                                                      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">

                                                      <input type="text" class="form-control" id="default-01" placeholder="Product Name" name="Pname" value="<?= $fetch_products['name']; ?>">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-sm-6">
                                                <div class="form-group">
                                                   <label class="form-label" for="default-textarea">Description</label>
                                                   <input type="hidden" name="Pid" value="<?= $fetch_products['id']; ?>">

                                                   <input type="text" class="form-control" id="default-01" placeholder="Product Name" name="desc" value="<?= $fetch_products['description']; ?>">

                                                   <div class="form-control-wrap">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-sm-4">
                                                <div class="form-group">
                                                   <label class="form-label" for="default-06">Default File Upload</label>
                                                   <div class="form-control-wrap">
                                                      <div class="form-file">
                                                         <input type="file" name="Pimage" accept="image/jpg, image/jpeg, image/png" multiple class="form-file-input" id="customFile">
                                                         <label class="form-file-label" for="customFile">Choose file</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-sm-4">
                                                      <div class="form-group">
                                                         <div class="form-control-wrap">
                                                            <div class="form-file">
                                                               <input type="submit" value="update product" class="btn" name="update_prod">

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