<?php
$stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$my_cart = array();
$subtotal = 0.00;
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_keys($products_in_cart));
    $my_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
    $products_in_cart  = array();
}

?>
<!-- main header @s -->
<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="html/index.html" class="logo-link">
                    <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                    <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                            <span class="" style="color:white; background: red; position:absolute; top:-10px; right: -5px; width:20px; height:20px; border-radius:50%; font-size:10px; display:flex; justify-content:center; align-items:center;"><?php echo array_sum($_SESSION['cart']) ?></span>
                            <em class="icon ni ni-cart"></em>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">My cart</span>
                                <form method="post">
                                    <button name="clear_cart" type="submit" class="btn btn-dim btn-danger btn-xs">Clear cart</button>
                                </form>
                            </div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    <?php
                                    if (!empty($products_in_cart)) {
                                        foreach ($my_cart as $product) { ?>
                                            <div class="nk-notification-item dropdown-inner">
                                                <div class="nk-notification-icon">
                                                    <img src="<?php echo $product['image'] ?? "./images/no-image.png" ?>" class="rounded" style="object-fit: cover;" alt="product-image" width="40" height="40" />
                                                </div>
                                                <div class="nk-notification-content">
                                                    <div class="nk-notification-text"><?php echo $product['name'] ?></div>
                                                    <div class="nk-notification-time"><?php echo  $products_in_cart[$product['id']] ?> creat in cart</div>
                                                </div>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-text">Your cart is empty</div>
                                        </div>
                                    <?php }

                                    ?>

                                </div><!-- .nk-notification -->
                            </div><!-- .nk-dropdown-body -->
                            <?php
                            if (!empty($products_in_cart)) { ?>
                                <div class="dropdown-foot center">
                                    <a href="/moha/agent/cart.php">View All</a>
                                </div>
                            <?php }
                            ?>

                        </div>
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-name dropdown-indicator"><?php echo $user['name'] ?></div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span><?php echo substr($user['name'], 0, 2) ?></span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text"><?php echo $user['name'] ?></span>
                                        <span class="sub-text"><?php echo $user['phone_number'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="/moha/agent/profile.php"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    <li><a href="/moha/agent/security.php"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="/moha/src/logout.php"><em class="icon ni ni-signout"></em><span>Log out</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>
<!-- main header @e -->