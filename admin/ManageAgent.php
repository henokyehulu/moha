<?php
require_once "../src/needs_auth.php";
require_once "../config.php";
   

 



 if(isset($_POST['changestatus'])){
    $status=$_POST['status'];
        $stmt = $pdo->prepare("UPDATE user SET status=:status where id=:id");
        $stmt->execute([
        "status"=> $status,
        "id"=> $_POST['id']],
        );
         echo "<script>
            window.location.href='/moha/admin/ManageAgent.php';
            alert('status updaated successfully!');
            </script>";
    }


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <title>Home</title>

</head>

<body>
    <p>Hello big 🍆 <strong><?php  echo $_SESSION['name'] ?></strong>. Here you go</p>
    <pre>
        id: <?php  echo $_SESSION['id'] ?>,
        name: <?php  echo $_SESSION['name'] ?>,
        role: <?php  echo $_SESSION['role'] ?>,
        session expires on: <?php  echo date('m/d/Y H:i:s', $_SESSION['expires_at']) ." (". date("H:i:s",$_SESSION['expires_at'] - time())  ." left)"; ?>

   

 <section class="col">

 </section>
 <div class="col">
  <h1>Manage user</h1>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Role</th>

      <th scope="col">status</th>

                        <th scope="col">Action</th>




    </tr>
  </thead>
  <tbody>
   
   <?php
              $stmt =$pdo->prepare("SELECT user.id,user.name,user.status,(role.name) as role_name FROM user inner join role on role.id=role where role.name!='admin'"); 
              $stmt->execute();
              $stmt->setFetchMode(PDO::FETCH_OBJ);
              $result=$stmt->fetchAll();
              if($result){
                foreach($result as $row){

                    ?>
                      <tr>
      <td><?=$row->id; ?></td>
        <td><?=$row->name;?></td>
        <td><?=$row->role_name;?></td>

    <td><?=$row->status;?></td>
        <td>

                <?php 
                                if($row->status==="pending"){
                                    ?>
                                                  <form method="post">

                                     <select name="status" id="">
                                                        <option value="">pending</option>

                            <option value="active">active</option>
                            

                        </select>
                                                                <input name="id" value="<?=$row->id; ?>" hidden required />

                                                <button name="changestatus" type="submit">Change status</button>
                                                </form>

                                                                    
                                <?php
                
              } 
else{
?>
<form method="post">
 <select name="status" id="">
    <option value="active">active</option>
    <option value="pending">pending</option>


                        </select>
                    <input name="id" value="<?=$row->id; ?>" hidden required />

                        <button name="changestatus" type="submit">Change status</button>
                    </form>
                   <?php
                }
                   ?>  
            </td>


                 

        



    </tr>
    
    
    <?php
                }
              } 

    ?>

  
  </tbody>
</table>

</div>

 
</div>

    <a href="../src/logout.php">Logout</a>
</body>

</html>