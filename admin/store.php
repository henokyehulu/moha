<?php
require_once "../config.php";

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
    <div class="col">
  <h1>Store </h1>
  <h2>add to store</h2>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
            <th scope="col">Name</th>
      <th scope="col">Quantity</th>
            <th scope="col">Amount </th> 
                        <th scope="col">Date</th>

                        <th scope="col">Action</th>




    </tr>
  </thead>
  <tbody>
   
   <?php
              $stmt =$pdo->prepare("SELECT * FROM store "); 
              $stmt->execute();
              $stmt->setFetchMode(PDO::FETCH_OBJ);
              $result=$stmt->fetchAll();
              if($result){
                foreach($result as $row){

                    ?>
                      <tr>
      <td><?=$row->id; ?></td>
        <td><?=$row->name;?></td>
    <td><?=$row->quantity;?></td>
        <td><?=$row->Amount?> bottle</td>
                <td><?=$row->date?></td>

        <td><a href="addtostore.php?add=<?=$row->id;?>" ">Add to Store</a></td>


                 

        



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