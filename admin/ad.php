<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT * FROM ads ");
$stmt->execute([]);
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once "../config.php";
if (isset($_POST["postad"])) {
    $Pname = $_POST['Pname'];
    $desc = $_POST['desc'];
    $Pimage = $_FILES['Pimage']['name'];
    $Pimage_tmp_name = $_FILES['Pimage']['tmp_name'];
    $Pimagefolder = '../uploadad/' . $Pimage;


    $stmt = $pdo->prepare("SELECT * FROM ads WHERE name=:Pname");
    $stmt->execute([
        'Pname' => $Pname,
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        $stmt = $pdo->prepare("INSERT INTO ads(name,description,image)VALUES(:Pname,:desc,:Pimage)");
        $stmt->execute([
            'Pname' => $Pname,
            'desc' => $desc,
            'Pimage' => 'uploadad/' . $Pimage,

        ]);

        move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
        echo "<script>
             window.location.href='/moha/admin/ad.php';
             alert('Product Added successfully!');
             </script>";
    } else {
        echo "Product Name is already exist.";
    }
}
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delete_vehicle_image = $pdo->prepare("SELECT image FROM `ads` WHERE id = ?");
    $delete_vehicle_image->execute([$delete_id]);
    $fetch_delete_image = $delete_vehicle_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploadad/' . $fetch_delete_image['image']);
    $delete_vehicle = $pdo->prepare("DELETE FROM `ads` WHERE id = ?");
    $delete_vehicle->execute([$delete_id]);
    echo "<script>
    window.location.href='/moha/admin/ad.php';
    alert('Product Deleted successfully!');
    </script>";
}

?>
<!DOCTYPE html>
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
    <title>Agent | Transactions</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <?php include_once "../admin/lib/sidebar.php" ?>
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <?php include_once "../admin/lib/header.php" ?>

                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">My ads</h3>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li class="nk-block-tools-opt">
                                                            <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Post Advertisment</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <?php
                                        if (empty($ads)) {

                                            echo "No ads added yet.";
                                        } else {
                                            foreach ($ads as $vehicle) { ?>
                                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                                    <div class="card card-bordered vehicle-card">
                                                        <div class="vehicle-thumb">
                                                            <a href="/moha/customer/vehicle-detail.php?id=<?php echo $vehicle['id'] ?>">
                                                                <img class="card-img-top" src="<?php echo $vehicle['image'] ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="card-inner text-center">
                                                            <!-- <ul class="vehicle-tags">
                                                                <li><a href="#">
                                                                    </a></li>
                                                            </ul> -->
                                                            <h5 class="vehicle-title">
                                                                <?php echo $vehicle['name'] ?> </a>
                                                            </h5>
                                                            <div class="vehicle-price text-primary h5"><?php echo $vehicle['description'] ?>
                                                            </div>
                                                            <form method="post">
                                                                <input type="text" name="id" value="<?php echo $vehicle['id'] ?>" hidden>
                                                                <a href="admin/ad.php?delete=<?= $vehicle['id']; ?>" onclick="return confirm('Delete this Product?');" class="btn btn-danger btn-xs">Delete</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php       }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <section class="col">
                    <form method="post" enctype='multipart/form-data'>
                        <div class="nk-add-vehicle toggle-slide toggle-slide-right" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar>
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title">Add New Vechicle</h5>
                                    <div class="nk-block-des">
                                        <p>Add information and add new Vechicle.</p>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="vehicle-title">Product Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="Pname" class="form-control" placeholder="Brand" aria-label="First name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="regular-price">Description</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="desc" class="form-control" placeholder="Plate Number" aria-label="First name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <input type="file" accept="image/png,image/jpg,image/jpeg" name="Pimage" class="box" id="chooseFile">
                                        <div class="col-12">
                                            <div class="upload-zone small bg-lighter my-2">
                                                <div class="dz-message">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type='submit' value='postad' name='postad' class="btn btn-primary mt-3 " />
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                    </form>
                </section>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    </section>
    </div>
    <!-- content @e -->
    <!-- footer @s -->
    <?php include_once "./lib/footer.php" ?>
    <!-- footer @e -->
    </div>
    <!-- wrap @e -->
    </div>
    <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>
    <script src="./assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>