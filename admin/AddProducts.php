<?php
require_once "../src/needs_auth.php";
require_once "../config.php";
if (isset($_POST["addproduct"])) {
    $Pname = $_POST['Pname'];
    $Price = $_POST['Price'];
    $desc = $_POST['desc'];
    $Pimage = $_FILES['Pimage']['name'];
    $Pimage_tmp_name = $_FILES['Pimage']['tmp_name'];
    $Pimagefolder = '../uploadproduct/' . $Pimage;


    $stmt = $pdo->prepare("SELECT * FROM product WHERE name=:Pname");
    $stmt->execute([
        'Pname' => $Pname,
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        $stmt = $pdo->prepare("INSERT INTO product(name,price,description,image)VALUES(:Pname,:Price,:desc,:Pimage)");
        $stmt->execute([
            'Pname' => $Pname,
            'Price' => $Price,
            'desc' => $desc,
            'Pimage' => 'uploadproduct/' . $Pimage,

        ]);
        $stmt = $pdo->prepare("INSERT INTO store(name)VALUES(:Pname)");
        $stmt->execute([
            'Pname' => $Pname,

        ]);

        move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
        echo "<script>
             window.location.href='/moha/admin/ManageProduct.php';
             alert('Product Added successfully!');
             </script>";
    } else {
        echo "Product Name is already exist.";
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_product_image = $pdo->prepare("SELECT image FROM `product` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploadproduct/' . $fetch_delete_image['image']);
    $delete_product = $pdo->prepare("DELETE FROM `product` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    //$delete_cart->execute([$delete_id]);
    header("location:../admin/ManageProduct.php");
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
        $message[] = "could not add the product ";
    }
}
if (isset($_GET['delete'])) {
    $delete_product_image = $pdo->prepare("SELECT image FROM `ads` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploadsad/' . $fetch_delete_image['image']);
    $delete_product = $pdo->prepare("DELETE FROM `ad` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    //$delete_cart->execute([$delete_id]);
    header("location:../admin/index.php");
}


?>
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
    <title>Agent | Add oroduct</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../admin/lib/sidebar.php"); ?>

        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php include("../admin/lib/header.php"); ?>
            <pre>
    </head>
 <section >
   <form method="post" enctype='multipart/form-data' >
    <h1 alig center>Add Products</h1>
       
 <div class="input-group mt-3">
     <input type="text" name="Pname" class="box" placeholder="Product name" aria-label="Product name">

</div>
<div class="input-group mt-3">
    <input type="number" name="Price"class="box" placeholder="Price" aria-label="Price">

</div>

<div class="input-group mt-3">
    <input type="text" name="desc" class="box" placeholder="description" aria-label="description">

</div>
<div class="input-group mt-3">
           <input type="file" accept="image/png,image/jpg,image/jpeg" 
           name="Pimage" class="box" id="chooseFile">

</div>
        <input type='submit' value='Addproduct'  name='addproduct' class="btn btn-primary mt-3 " />
       
</form>
 </section>

  

    <a href="../src/logout.php">Logout</a>
</body>

</html>