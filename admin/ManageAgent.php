<?php
include_once "../config.php";
include_once "../src/needs_auth.php";

$stmt = $pdo->prepare("SELECT * FROM user where role=3 ");
$stmt->execute();
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['changestatus'])) {
  $status = $_POST['status'];
  $stmt = $pdo->prepare("UPDATE user SET status=:status where id=:id");
  $stmt->execute(
    [
      "status" => $status,
      "id" => $_POST['id']
    ],
  );
  echo "<script>
            window.location.href='/moha/admin/ManageAgent.php';
            alert('status updaated successfully!');
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
  <title>Admin | Manage agents</title>
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
                      <h3 class="nk-block-title page-title">Manage agents</h3>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                      <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>

                      </div>
                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                  <div class="nk-tb-list is-separate is-medium mb-3">
                    <div class="nk-tb-item nk-tb-head">
                      <div class="nk-tb-col"><span>ID</span></div>
                      <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                      <div class="nk-tb-col"><span class="d-none d-sm-block">Status</span></div>
                      <div class="nk-tb-col tb-col-sm"><span>Name</span></div>
                      <div class="nk-tb-col tb-col-md"><span>TIN</span></div>
                      <div class="nk-tb-col tb-col-md"><span>Delivery trucks libre</span></div>
                      <div class="nk-tb-col tb-col-md"><span>Store lease</span></div>
                      <div class="nk-tb-col"><span></span></div>
                    </div><!-- .nk-tb-item -->
                    <?php if (empty($agents)) : ?>
                      <div class="nk-tb-col">
                        <span>You have no agents registered yet</span>
                      </div>
                    <?php else : ?>
                      <?php foreach ($agents as $agent) : ?>
                        <div class="nk-tb-item">
                          <div class="nk-tb-col">
                            <span class="tb-lead"><a>#<?php echo $agent['id'] ?></a></span>
                          </div>
                          <div class="nk-tb-col tb-col-md">
                            <span class="tb-sub"><?php echo date("d/m/Y", strtotime($agent['created_at']));  ?></span>
                          </div>
                          <div class="nk-tb-col">
                            <span class="dot bg-warning d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg  <?php echo $agent['status'] == "active" ? "bg-success" : "bg-warning" ?> d-none d-sm-inline-flex"><?php echo ucwords($agent['status']) ?></span>
                          </div>
                          <div class="nk-tb-col tb-col-sm">
                            <span class="tb-sub"><?php echo ucwords($agent['name']) ?></span>
                          </div>
                          <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                              <?php
                              if (!is_null($agent['tin'])) { ?>
                                <li>
                                  <a href="<?php echo "moha/" . $agent['tin'] ?>" class="btn btn-icon btn-trigger btn-tooltip" aria-label="View Document" data-bs-original-title="View Document">

                                    <em class="icon ni ni-eye"></em>
                                  </a>
                                </li>
                              <?php }
                              ?>
                            </ul>
                          </div>
                          <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                              <?php
                              if (!is_null($agent['delivery_trucks_libre'])) { ?>
                                <li>
                                  <a href="<?php echo "moha/" . $agent['delivery_trucks_libre'] ?>" class="btn btn-icon btn-trigger btn-tooltip" aria-label="View Document" data-bs-original-title="View Document">

                                    <em class="icon ni ni-eye"></em>
                                  </a>
                                </li>
                              <?php }
                              ?>
                            </ul>
                          </div>
                          <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                              <?php
                              if (!is_null($agent['store_lease'])) { ?>
                                <li>
                                  <a href="<?php echo "moha/" . $agent['store_lease'] ?>" class="btn btn-icon btn-trigger btn-tooltip" aria-label="View Document" data-bs-original-title="View Document">

                                    <em class="icon ni ni-eye"></em>
                                  </a>
                                </li>
                              <?php }
                              ?>
                            </ul>
                          </div>
                          <div class="nk-tb-col">
                            <form method="post" id="status-select">
                              <select name="status" class="form-select js-select2" required>
                                <option <?php if ($agent['status'] == "active") { ?> selected <?php } ?> value="active">Active</option>
                                <option <?php if ($agent['status'] == "pending") { ?> selected <?php } ?> value="pending">Pending</option>
                              </select>

                              <input name="id" value="<?php echo $agent['id']; ?>" hidden required />

                              <button name="changestatus" type="submit" class="btn btn-primary mt-3">Change status</button>
                            </form>
                          </div>
                          <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                              <?php
                              if ($agent['status'] == 'agent_delivered') { ?>
                                <li>
                                  <form method="post">
                                    <input name="id" value="<?php echo $agent['id'] ?>" type="id" hidden required />
                                    <button type="submit" name="mark_as_received" class="btn btn-icon btn-trigger btn-tooltip" aria-label="View Document" data-bs-original-title="View Document">

                                      <em class="icon ni ni-truck"></em>
                                    </button>
                                  </form>
                                </li>
                              <?php }
                              ?>
                              <?php
                              if ($agent['status'] == 'success') { ?>
                                <li>
                                  <a href="/moha/agent/invoice.php?id=<?php echo $agent['id'] ?>" class="btn btn-icon btn-trigger btn-tooltip" aria-label="View Invoice" data-bs-original-title="View Invoice">
                                    <em class="icon ni ni-eye"></em>
                                  </a>
                                </li>
                              <?php }
                              ?>

                            </ul>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- .nk-tb-item -->




                  </div><!-- .nk-tb-list -->

                </div>
              </div>
            </div>
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