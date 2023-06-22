<?php
require_once "../config.php";

 if(isset($_POST["addproduct"])) {
    $Pname = $_POST['Pname'];
    $Price = $_POST['Price'];
    $desc = $_POST['desc'];
    $Pimage=$_FILES['Pimage']['name'];
    $Pimage_tmp_name=$_FILES['Pimage']['tmp_name'];
    $Pimagefolder='../uploads/'.$Pimage;


 $stmt =$pdo->prepare("SELECT * FROM product WHERE name=:Pname"); 
        $stmt->execute([
            'Pname'=>$Pname,
        ]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
        if ($stmt->rowCount() === 0){
$stmt=$pdo->prepare("INSERT INTO product(name,price,description,image)VALUES(:Pname,:Price,:desc,:Pimage)");
   $stmt->execute([
                'Pname'=>$Pname,
                'Price'=>$Price,
                'desc'=> $desc,
                  'Pimage'=> $Pimage,
               
            ]);
            $stmt=$pdo->prepare("INSERT INTO store(name)VALUES(:Pname)");
             $stmt->execute([
                'Pname'=>$Pname,
               
            ]);

             move_uploaded_file($Pimage_tmp_name,$Pimagefolder);
                $message[]="add successfully";
            header("location:../admin/index.php");
}
                
            else{
   echo "Product Name is already exist.";}}

    if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $pdo->prepare("SELECT image FROM `product` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploads/'.$fetch_delete_image['image']);
   $delete_product = $pdo->prepare("DELETE FROM `product` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   //$delete_cart->execute([$delete_id]);
            header("location:../admin/index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="col">
   <form method="post" enctype='multipart/form-data' >
    <h1>Add Products</h1>
       
 <div class="input-group mt-3">
     <input type="text" name="Pname" class="box" placeholder="Product name" aria-label="First name">

</div>
<div class="input-group mt-3">
    <input type="number" name="Price"class="box" placeholder="Price" aria-label="Last name">

</div>

<div class="input-group mt-3">
    <input type="text" name="desc" class="box" placeholder="description" aria-label="First name">

</div>
<div class="input-group mt-3">
           <input type="file" accept="image/png,image/jpg,image/jpeg" 
           name="Pimage" class="box" id="chooseFile">

</div>
        <input type='submit' value='addproduct'  name='addproduct' class="btn btn-primary mt-3 " />
        hello world

</form>
</section>
 <div class="col">
  <h1>Manage Product</h1>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Prodcut Image</th>
            <th scope="col">Name</th>
      <th scope="col">Price</th>
            <th scope="col">description</th>
                        <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
   
   <?php
              $stmt =$pdo->prepare("SELECT * FROM product "); 
              $stmt->execute();
              $stmt->setFetchMode(PDO::FETCH_OBJ);
              $result=$stmt->fetchAll();
              if($result){
                foreach($result as $row){

                    ?>
                      <tr>
      <td><?=$row->id; ?></td>
    <td><img src="../uploads/<?php echo $row->image;?>" class="rounded mx-auto d-block "  alt="product_imaget" style="width: 100px; height:100px;"></td>
        <td><?=$row->name;?></td>
    <td>$<?=$row->price;?></td>
        <td><?=$row->description;?></td>
        <td><a href="updatepro.php?update=<?=$row->id;?>" ">Update</a></td>
                <td><a href="index.php?delete=<?=$row->id;?>" onclick="return confirm('Delete this Product?');">Delete</a></td>
    </tr>
    
    
    <?php
                }
              } 

    ?>

  
  </tbody>
</table>

</div>

 
</body>
</html>