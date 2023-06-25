<?php
require_once "../src/needs_auth.php";
require_once "../config.php";
if (isset($_POST["Addproduct"])) {
    $Pname = $_POST['Pname'];
    $Price = $_POST['Price'];
    $desc = $_POST['desc'];
    $Pimage = $_FILES['Pimage']['name'];
    $Pimage_tmp_name = $_FILES['Pimage']['tmp_name'];
    $Pimagefolder = '../uploads/' . $Pimage;


    $stmt = $pdo->prepare("SELECT * FROM agent_store_products WHERE name=:Pname");
    $stmt->execute([
        'Pname' => $Pname,
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        $stmt = $pdo->prepare("INSERT INTO agent_store_products(name,price,description,image)VALUES(:Pname,:Price,:desc,:Pimage)");
        $stmt->execute([
            'Pname' => $Pname,
            'Price' => $Price,
            'desc' => $desc,
            'Pimage' => $Pimage,

        ]);
        move_uploaded_file($Pimage_tmp_name, $Pimagefolder);
        $message[] = "add successfully";
        header("location:../agent/product-list.php");
    } else {
        echo "Product Name is already exist.";
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_product_image = $pdo->prepare("SELECT image FROM `agent_store_products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('./uploads/' . $fetch_delete_image['image']);
    $delete_product = $pdo->prepare("DELETE FROM `agent_store_products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    //$delete_cart->execute([$delete_id]);
    header("location:../agent/product-list.php");
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
        $message[] = "could not add the product";
    }
}
if (isset($_GET['delete'])) {
    $delete_product_image = $pdo->prepare("SELECT image FROM `ad` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploadsad/' . $fetch_delete_image['image']);
    $delete_product = $pdo->prepare("DELETE FROM `ad` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    //$delete_cart->execute([$delete_id]);
    header("location:../agent/product-list.php");
}


?>

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
            <?php include_once "../agent/lib/sidebar.php" ?>
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <?php include_once "../agent/lib/header.php" ?>
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Products in stock</h3>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li>
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni ni-search"></em>
                                                                </div>
                                                                <input type="text" class="form-control" id="default-04" placeholder="Quick search by id">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle dropdown-indicator btn btn-outline-light btn-white" data-bs-toggle="dropdown">Status</a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><span>New Items</span></a></li>
                                                                        <li><a href="#"><span>Featured</span></a></li>
                                                                        <li><a href="#"><span>Out of Stock</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="nk-block-tools-opt">
                                                            <a href="#" data-target="addProduct" class="toggle btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                                                            <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add New Product</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card">
                                        <div class="card-inner-group">
                                            <div class="card-inner p-0">
                                                <div class="nk-tb-list">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">No</th>
                                                                    <th scope="col">Prodcut Image</th>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Price</th>
                                                                    <th scope="col">description</th>
                                                                    <th scope="col">Update</th>
                                                                    <th scope="col">Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $stmt = $pdo->prepare("SELECT * FROM agent_store_products ");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_OBJ);
                                                                $result = $stmt->fetchAll();
                                                                if ($result) {
                                                                    foreach ($result as $row) { ?>
                                                                        <tr>
                                                                            <td><?= $row->id; ?></td>
                                                                            <td><img src="./uploads/<?php echo $row->image; ?>" class="card-img-top " alt="product_image" style="width: 100px; height:100px;"></td>
                                                                            <td><?= $row->name; ?></td>
                                                                            <td>$<?= $row->price; ?></td>
                                                                            <td><?= $row->description; ?></td>
                                                                            <td><a href="agent/updatepro.php?update=<?= $row->id; ?>" class="icon ni ni-edit"></a></td>
                                                                            <td><a href="/agent/product-list.php?delete=<?= $row->id; ?>" class="icon ni ni-trash" onclick="return confirm('Delete this Product?');"></a></td>
                                                                        </tr>
                                                                <?php }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <section class="col">
                                                        <form method="post" enctype='multipart/form-data'>
                                                            <div class="nk-add-product toggle-slide toggle-slide-right" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar>
                                                                <div class="nk-block-head">
                                                                    <div class="nk-block-head-content">
                                                                        <h5 class="nk-block-title">New Product</h5>
                                                                        <div class="nk-block-des">
                                                                            <p>Add information and add new product.</p>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- .nk-block-head -->
                                                                <div class="nk-block">
                                                                    <div class="row g-3">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="product-title">Product Name</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" name="Pname" class="form-control" placeholder="Product name" aria-label="First name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="regular-price">Discribtion</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" name="desc" class="form-control" placeholder="description" aria-label="First name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="sale-price">Sale Price</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input type="number" name="Price" class="form-control" placeholder="Price" aria-label="Last name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="stock">Stock</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control" id="stock">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="upload-zone small bg-lighter my-2">
                                                                                <div class="dz-message">
                                                                                    <input type="file" accept="image/png,image/jpg,image/jpeg" name="Pimage" class="dz-message-text">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <input type='submit' value='Addproduct' name='Addproduct' class="btn btn-primary mt-3 " />
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


                                <!-- footer @s -->
                                <div class="nk-block-between-md g-3">
                                    <div class="g">
                                        <ul class="pagination justify-content-center justify-content-md-start">
                                            <li class="page-item"><a class="page-link" href=""><em class="icon ni ni-chevrons-left"></em></a></li>
                                            <li class="page-item"><a class="page-link" href="">1</a></li>
                                            <li class="page-item"><a class="page-link" href="">2</a></li>
                                            <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                            <li class="page-item"><a class="page-link" href="">6</a></li>
                                            <li class="page-item"><a class="page-link" href="">7</a></li>
                                            <li class="page-item"><a class="page-link" href=""><em class="icon ni ni-chevrons-right"></em></a></li>
                                        </ul><!-- .pagination -->
                                    </div>
                                </div>
                            </div><!-- .pagination-goto -->
                        </div><!-- .nk-block-between -->
                    </div>
                </div>
            </div>
        </div><!-- .nk-block -->
        <?php include("../agent/partials/footer.php"); ?>
        <!-- footer @e -->
        <!-- JavaScript -->
        <script src="./assets/js/bundle.js?ver=3.1.3"></script>
        <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>