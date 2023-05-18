<?php  
      include_once("../config.php");
      include_once("../src/needs_auth.php");
      if(count($_SESSION['cart'])==0){
        header("location:/moha/customer/order.php");
      }
      $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
      $products = array();
      $subtotal = 0.00;
      $shipping = 0.00;
      $total = 0.00;
      if ($products_in_cart) {
          $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
          $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
          $stmt->execute(array_keys($products_in_cart));
          $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          foreach ($products as $product) {
              $subtotal += (float)($product['price'] * (int)$products_in_cart[$product['id']] * 24);
            }
            $shipping+= array_sum($products_in_cart) * 50;
            $total=$shipping +$subtotal;
      }
      
      if(isset($_POST['make_order'])){
            $stmt = $pdo->prepare("INSERT INTO tbl_order (user, amount) VALUES(:user, :amount)");
            $stmt->execute([
                'user'=>intval($user_id),
                'amount'=>$total,
            ]);

            $_SESSION['cart'] = [];
       
        echo "<script>
        window.location.href='/moha/customer/my-orders.php';
        alert('Order successfully placed!');
        </script>";
      }
      
     
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>

<body>
    <a href="/moha/customer/cart.php">back</a>

    <p>Cart:</p>
    <table>
        <tbody>
            <?php if (empty($products)): ?>
            <tr>
                <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
            </tr>
            <?php else: ?>
            <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <p> x<?php echo $products_in_cart[$product['id']]." " .$product['name']?> creat</p>
                </td>
                <td class="price">&dollar;<?php echo $product['price'] * $products_in_cart[$product['id']] * 24?></td>

            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="text" colspan="5">Subtotal</td>
                <td style="text-align: end;" colspan="3" class="price">
                    &dollar;<?php echo $subtotal?>
                </td>
            </tr>
            <tr>
                <td class="text" colspan="5">Shipping</td>
                <td style="text-align: end;" colspan="3" class="price">
                    &dollar;<?php echo $shipping?>
                </td>
            </tr>
            <tr>
                <td class="text" colspan="5">Total</td>
                <td style="text-align: end;" colspan="3" class="price">
                    &dollar;<?php echo $total?>
                </td>
            </tr>
        </tfoot>
    </table>
    <form method="post">
        <button name="make_order" type="submit">Make order</button>
    </form>
</body>

</html>