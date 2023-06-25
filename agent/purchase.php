<?php 
if(isset($_POST['purchase'])){
            $stmt = $pdo->prepare("INSERT INTO tbl_order (user, amount) VALUES(:user, :amount)");
            $stmt->execute([
                'user'=>intval($user_id),
                'amount'=>$total,
            ]);

            $_SESSION['cart'] = [];
       
        echo "<script>
        window.location.href='/moha/agent/email.php';
        alert('Order successfully placed!');
        </script>";
      }
