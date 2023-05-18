<?php  
    include_once("../config.php");
    include_once("../src/needs_auth.php");
    $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $products = array();
    $subtotal = 0.00;
    if ($products_in_cart) {
        $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
        $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
        $stmt->execute(array_keys($products_in_cart));
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($products as $product) {
            $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']] * 24;
        }
    }
  
    if(isset($_POST['remove_product'])){
        $product_id = $_POST['id'];
        unset($_SESSION['cart'][$product_id]);
        header("location:/moha/customer/cart.php");
    }
    
    if(isset($_POST['update_creat'])){
        $product_id = $_POST['id'];
        $creat = $_POST['creat'];
        $_SESSION['cart'][$product_id] = $creat;
        header("location:/moha/customer/cart.php");
    }

    if(isset($_POST['clear_cart'])){
        $_SESSION['cart'] = [];
        header("location:/moha/customer/cart.php");
    }

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>

<body>
    <a href="/moha/customer/order.php">back</a>
    <table border="1">
        <thead>
            <td>Product</td>
            <td>Price per pice</td>
            <td>Creats</td>
            <td>Total</td>
            <td>Action</td>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
            <tr>
                <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
            </tr>
            <?php else: ?>
            <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <p><?php echo $product['name']?></p>
                </td>
                <td class="price">&dollar;<?php echo $product['price']?></td>
                <td class="creats">
                    <form method="post">
                        <input type="number" name="id" value="<?php echo $product['id']?>" required hidden />
                        <input type="number" name="creat" value="<?php echo $products_in_cart[$product['id']]?>" min="1"
                            required />
                        <button name="update_creat">Update</button>
                    </form>
                </td>
                <td class="price">&dollar;<?php echo $product['price'] * $products_in_cart[$product['id']] * 24?></td>
                <td class="price">
                    <form method="post">
                        <input name="id" value="<?php echo $product['id']?>" hidden required />
                        <button name="remove_product" type="submit">Remove</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="text" colspan="2">Subtotal</td>
                <td style="text-align: end;" colspan="3" class="price">
                    &dollar;<?=$subtotal?>
                </td>
            </tr>
        </tfoot>
    </table>
    <form method="post">
        <button name="clear_cart" type="submit">Clear cart</button>
    </form>
    <a href="/moha/customer/checkout.php">checkout</a>
</body>

</html>