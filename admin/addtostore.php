<?php
require_once "../config.php";
  if(isset($_POST["add"])) {
        $pid = $_POST['Pid'];
        $qty_prev=$_POST['qty_prev'];
                $qty = $_POST['qty']+$qty_prev;
                $amount=$qty*24;
 $update_product = $pdo->prepare("UPDATE `store` SET  quantity=? ,amount=?  WHERE id = ?");
   $update_product->execute([$qty,$amount,$pid]);
      $message[] = ' update stored successfully!';

                        }
            else{
   echo "Product Name is already exist.";}
  ?>
  <!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom admin style link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
      $update_id = $_GET['add'];
      $select_products = $pdo->prepare("SELECT * FROM `store` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" enctype="multipart/form-data" method="post">
      <input type="hidden" name="Pid" value="<?= $fetch_products['id']; ?>">
            <input type="number" ass="box"  maxlength="10" hidden name="qty_prev" value="<?= $fetch_products['quantity']; ?>">

      <input type="number" ass="box"  maxlength="100" name="qty" >
      <p><?= $fetch_products['quantity']; ?></p>

<p><?= $fetch_products['Amount']; ?> bottles</p>
      <div class="flex-btn">
         
         <input type="submit" value="add to store" class="btn" name="add">
         <a href="store.php" class="option-btn">go back</a>
      </div>
   </form>

   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

</section>




<script src="js/admin_script.js"></script>

</body>
</html>