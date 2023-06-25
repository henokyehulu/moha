<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <title>Moha|Agent Dashboard </title>
    <?php include("../agent/partials/header.php"); ?>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <!-- sidebar @e -->
        <?php include("../agent/partials/sidebar.php"); ?>

        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php include("../agent/partials/sidebar.php"); ?>
            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview wide-md mx-auto">
                                <div class="nk-block-head nk-block-head-lg wide-sm">
                                    <div class="nk-block-head-content">
                                        <div class="nk-block-head-sub"><a class="back-to" href="agent/customer-list.php"><em class="icon ni ni-arrow-left"></em><span>back</span></a></div>
                                        <h2 class="nk-block-title fw-normal">Customer Form</h2>
                                        <div class="nk-block-des">
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="card">
                                    <div class="card-inner">
                                        <form action="formadd.php" method="Post">
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-full-name">Full Name</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="fva-full-name" name="full_name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-email">Email address</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni ni-mail"></em>
                                                            </div>
                                                            <input type="text" class="form-control" id="fva-email" name="email_address" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fv-phone">Sex / Gender</label>
                                                        <div class="form-control-wrap">
                                                            <ul class="custom-control-group">
                                                                <li>
                                                                    <div class="custom-control custom-radio custom-control-pro no-control">
                                                                        <input type="radio" class="custom-control-input" name="sex" id="alt-sex-male" required>
                                                                        <label class="custom-control-label" for="alt-sex-male">Male</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-radio custom-control-pro no-control">
                                                                        <input type="radio" class="custom-control-input" name="sex" id="alt-sex-female" required>
                                                                        <label class="custom-control-label" for="alt-sex-female">Female</label>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                    <div class="custom-control custom-radio custom-control-pro no-control">
                                                                        <input type="radio" class="custom-control-input" name="sex" id="alt-sex-other" required>
                                                                        <label class="custom-control-label" for="alt-sex-other">Other</label>
                                                                    </div>
                                                                </li>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-topics">For who</label>
                                                        <div class="form-control-wrap ">
                                                            <select class="form-control form-select" id="fva-topics" name="for_who" data-placeholder="Select a option" required>
                                                                <option label="Select your's" value=""></option>
                                                                <option value="fva-gq">Hotel</option>
                                                                <option value="fva-tq">Person</option>
                                                                <option value="fva-ab">Restorant</option>
                                                                <option value="fva-ab">Market</option>
                                                                <option value="fva-ab">Caffe</option>
                                                                <option value="fva-ab">Event</option>
                                                                <option value="fva-ab">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-phone">Phone</label>
                                                        <div class="form-control-wrap">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" name="phone" id="fv-phone">+251</span>
                                                                </div>
                                                                <input type="Number" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-address">Address</label>
                                                        <div class="form-control-wrap ">
                                                            <select class="form-control form-select" id="fva-topics" name="address" data-placeholder="Select a option" required>
                                                                <option label="Select location" value=""></option>
                                                                <option value="fva-gq">Bole</option>
                                                                <option value="fva-tq">Yeka</option>
                                                                <option value="fva-ab">Arada</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-06">Default File Upload</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-file">
                                                                <input type="file" multiple class="form-file-input" id="customFile">
                                                                <label class="form-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-message">Message</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-sm" id="fva-message" name="Message" placeholder="Write your message"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Communication</label>
                                                        <ul class="custom-control-group g-3 align-center">
                                                            <li>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="fva-com" id="fva-com-email" required>
                                                                    <label class="custom-control-label" for="fva-com-email">Email</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="fva-com" id="fva-com-sms" required>
                                                                    <label class="custom-control-label" for="fva-com-sms">SMS</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="fva-com" id="fva-com-phone" required>
                                                                    <label class="custom-control-label" for="fva-com-phone">Phone</label>
                                                                </div>
                                                            </li>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-primary">Save Informations</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- .nk-block -->
                        </div><!-- .components-preview -->
                    </div>
                </div>
            </div>
        </div>
        <!-- footer @s -->
        <?php include("../agent/partials/footer.php"); ?>
        <!-- footer @e -->
        <!-- JavaScript -->
        <script src="./assets/js/bundle.js?ver=3.1.3"></script>
        <script src="./assets/js/scripts.js?ver=3.1.3"></script>
</body>

</html>