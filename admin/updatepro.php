<?php
require_once "../config.php";
  if(isset($_POST["update_prod"])) {
        $pid = $_POST['Pid'];
    $Pname = $_POST['Pname'];
    $Price = $_POST['Price'];
    $desc = $_POST['desc'];
       $old_image = $_POST['old_image'];
    $Pimage=$_FILES['Pimage']['name'];
       $Pimage_size = $_FILES['Pimage']['size'];
    $Pimage_tmp_name=$_FILES['Pimage']['tmp_name'];
    $Pimagefolder='../uploads/'.$Pimage;
   
 $update_product = $pdo->prepare("UPDATE `product` SET name = ?, price = ? , description=? WHERE id = ?");
   $update_product->execute([$Pname, $Price,$desc, $pid]);
      $message[] = 'product updated successfully!';

        

 if(!empty($Pimage)){
      if($Pimage_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = $pdo->prepare("UPDATE `product` SET image = ? WHERE id = ?");
         $update_image->execute([$Pimage, $pid]);
         move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
         unlink('../uploads/'.$old_image);
         $message[] = 'image updated successfully!';
      }
   }
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
      $update_id = $_GET['update'];
      $select_products = $pdo->prepare("SELECT * FROM `product` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" enctype="multipart/form-data" method="post">
      <input type="hidden" name="Pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="../uploads/<?= $fetch_products['image']; ?>" alt="">
      <input type="text" class="box"  maxlength="100" placeholder="enter product name" name="Pname" value="<?= $fetch_products['name']; ?>">
            <input type="text" class="box"  placeholder="description" name="desc" value="<?= $fetch_products['description']; ?>">


      <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="Price" value="<?= $fetch_products['price']; ?>">
      <input type="file" name="Pimage" accept="image/jpg, image/jpeg, image/png" class="box">
      <div class="flex-btn">
         <input type="submit" value="update product" class="btn" name="update_prod">
         <a href="admin_products.php" class="option-btn">go back</a>
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