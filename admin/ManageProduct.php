<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT * FROM Product");
$stmt->execute();
$Products = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
  //unlink('../uploadproduct/' . $fetch_delete_image['image']);
  $delete_product = $pdo->prepare("DELETE FROM `product` WHERE id = ?");
  $delete_product->execute([$delete_id]);
  //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
  //$delete_cart->execute([$delete_id]);
  echo "<script>
  window.location.href='/moha/admin/ManageProduct.php';
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
                      <h3 class="nk-block-title page-title">My Products</h3>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                      <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                          <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                              <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add New Product</span></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="card">
                  <div class="card-inner-group">
                    <div class="card-inner p-0">
                      <div class="nk-tb-list">
                        <div class="nk-tb-item nk-tb-head">
                          <div class="nk-tb-col tb-col-sm"><span>ID</span></div>
                          <div class="nk-tb-col tb-col-sm"><span>Name</span></div>
                          <div class="nk-tb-col tb-col-sm"><span>Price</span></div>
                          <div class="nk-tb-col"><span>Description</span></div>
                          <div class="nk-tb-col tb-col-md"><span></span></div>
                        </div>
                        <?php if (empty($Products)) : ?>
                          <div>
                            <span class="p-5">You have no Products added in yet</span>
                          </div>
                        <?php else : ?>
                          <?php foreach ($Products as $vehicle) : ?>
                            <!-- .nk-tb-item -->
                            <div class="nk-tb-item">
                              <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub"><?php echo $vehicle['id'] ?></span>
                              </div>
                              <div class="nk-tb-col tb-col-sm">
                                <span class="tb-product">
                                  <img src="<?php echo $vehicle['image'] ?>" alt="" class="thumb">
                                  <span class="title"><?php echo $vehicle['name'] ?></span>
                                </span>
                              </div>
                              <div class="nk-tb-col">
                                <span class="tb-lead"> <?php echo $vehicle['price']  ?></span>
                              </div>
                              <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub"><?php echo $vehicle['description'] ?></span>
                              </div>
                              <form method="post" class="nk-tb-col nk-tb-col-tools">
                                <input name="id" value="<?php echo $vehicle['id'] ?>" hidden required />
                                <a href="./admin/updatepro.php?update=<?= $vehicle['id'] ?>" class="btn btn-primary btn-xs">Edit</a>

                              </form>
                              <form method=" post" class="nk-tb-col nk-tb-col-tools">
                                <input name="id" value="<?php echo $product['id'] ?>" hidden required />

                                <a href="admin/ManageProduct.php?delete=<?= $vehicle['id']; ?>" onclick="return confirm('Delete this Product?');" class="btn btn-danger btn-xs">Delete</a>
                              </form>
                            </div>
                            <!-- .nk-tb-item -->

                          <?php endforeach; ?>
                        <?php endif; ?>

                      </div><!-- .nk-tb-list -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <section class="col">
              <form method="post" enctype='multipart/form-data'>
                <div class="nk-add-product toggle-slide toggle-slide-right" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar>
                  <div class="nk-block-head">
                    <div class="nk-block-head-content">
                      <h5 class="nk-block-title">Add New Product</h5>
                      <div class="nk-block-des">
                        <p>Add information and add new Product.</p>
                      </div>
                    </div>
                  </div><!-- .nk-block-head -->
                  <div class="nk-block">
                    <div class="row g-3">
                      <div class="col-12">
                        <div class="form-group">
                          <label class="form-label" for="product-title">Name</label>
                          <div class="form-control-wrap">
                            <input type="text" name="Pname" class="form-control" placeholder="Brand" aria-label="First name">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="regular-price">Price</label>
                          <div class="form-control-wrap">
                            <input type="text" name="Price" class="form-control" placeholder="Price" aria-label="First name">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="regular-price">Description</label>
                          <div class="form-control-wrap">
                            <input type="text" name="desc" class="form-control" placeholder="description" aria-label="First name">
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
                        <input type='submit' value='Add Product' name='addproduct' class="btn btn-primary mt-3 " />
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