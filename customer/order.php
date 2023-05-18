<?php 
    include_once "../config.php";
    include_once "../src/needs_auth.php";
    $stmt = $pdo->prepare("SELECT * FROM  product");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(isset($_POST['add_to_cart'])){
        $product_id = (int) $_POST['id'];
        $creat = (int) $_POST['crate'];

        if(array_key_exists($product_id,$_SESSION['cart'])){
            $_SESSION['cart'][$product_id] += $creat;
        }else{
            $_SESSION['cart'][$product_id] = $creat;
        }

    }
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>

<body>
    <a href="/moha/customer/">back</a>
    <a href="/moha/customer/cart.php">My cart (<?php echo array_sum($_SESSION['cart']) ?>)</a>
    <p>Products</p>
    <?php 
        if(count($products) == 0 ){
            echo "No products added yet.";
        }
        else{   
            foreach ($products as $product) {?>
    <form method="post">
        <input name="id" value="<?php echo $product['id']?>" hidden required />
        <p>Product name:<?php echo $product['name']?></p>
        <p>Product price:<?php echo $product['price']?></p>
        <div style="display: flex; height:20px; align-items: center;">
            <p>Quantity (crate):</p>
            <input type="number" name="crate" min="1" value="1" required />
        </div>
        <button name="add_to_cart" type="submit">Add to cart</button>
    </form>

    <?php       }
        }
    ?>
</body>

</html>