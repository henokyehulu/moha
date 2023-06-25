<?php
require_once "../src/needs_auth.php";
require_once "../config.php";
require_once "../config.php";
if (isset($_POST["update_prod"])) {
   $pid = $_POST['Pid'];
   $Vname = $_POST['Vname'];
   $Plname = $_POST['Plname'];
   $Did = $_POST['Did'];
   $Vrole = $_POST['Vrole'];
   $old_image = $_POST['old_image'];
   $Pimage = $_FILES['Pimage']['name'];
   $Pimage_size = $_FILES['Pimage']['size'];
   $Pimage_tmp_name = $_FILES['Pimage']['tmp_name'];
   $Pimagefolder = '../uploads/' . $Pimage;

   $update_Vehicle = $pdo->prepare("UPDATE `agent_vehicles` SET vehicle = ?, plate_number = ? , driver_Id=? , vehicle_role=? WHERE id = ?");
   $update_Vehicle->execute([$Vname, $Plname, $Did, $Vrole, $pid]);
   $message[] = 'Vehicle updated successfully!';



   if (!empty($Pimage)) {
      if ($Pimage_size > 2000000) {
         $message[] = 'image size is too large!';
      } else {
         $update_image = $pdo->prepare("UPDATE `agent_vehicles` SET image = ? WHERE id = ?");
         $update_image->execute([$Pimage, $pid]);
         move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
         unlink('../uploads/' . $old_image);
         $message[] = 'image updated successfully!';
      }
   }
} else {
   echo "Vehicle Name is already exist.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update vehicles</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom admin style link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <section class="update-vehicles">

      <h1 class="heading">update vehicles</h1>

      <?php
      $update_id = $_GET['update'];
      $agent_vehicles = $pdo->prepare("SELECT * FROM `agent_vehicles` WHERE id = ?");
      $agent_vehicles->execute([$update_id]);
      if ($agent_vehicles->rowCount() > 0) {
         while ($fetch_agent_vehicles = $agent_vehicles->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <form action="" enctype="multipart/form-data" method="post">
               <input type="hidden" name="Pid" value="<?= $fetch_agent_vehicles['id']; ?>">
               <input type="hidden" name="old_image" value="<?= $fetch_agent_vehicles['image']; ?>">
               <img src="../uploads/<?= $fetch_agent_vehicles['image']; ?>" alt="">
               <input type="text" class="box" maxlength="100" placeholder="enter vehicle name" name="Vname" value="<?= $fetch_agent_vehicles['vehicle']; ?>">
               <input type="text" class="box" placeholder="plate_number" name="Plname" value="<?= $fetch_agent_vehicles['plate_number']; ?>">
               <input type="text" class="box" placeholder="vehicle_role" name="Vrole" value="<?= $fetch_agent_vehicles['vehicle_role']; ?>">
               <input type="number" min="0" class="box" required max="9999999999" placeholder="enter driver_Id" onkeypress="if(this.value.length == 10) return false;" name="Did" value="<?= $fetch_agent_vehicles['driver_Id']; ?>">
               <input type="file" name="Pimage" accept="image/jpg, image/jpeg, image/png" class="box">
               <div class="flex-btn">
                  <input type="submit" value="update vehicle" class="btn" name="update_prod">
                  <a href="Vehicles-manage.php" class="option-btn">go back</a>
               </div>
            </form>

      <?php
         }
      } else {
         echo '<p class="empty">no vehicle found!</p>';
      }
      ?>

   </section>




   <script src="js/admin_script.js"></script>

</body>

</html>