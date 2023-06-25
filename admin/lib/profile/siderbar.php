<!-- card-aside -->
<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar bg-primary">
                    <span><?php echo substr($admin['name'], 0, 2) ?></span>
                </div>
                <div class="user-info">
                    <span class="lead-text"><?php echo $admin['name'] ?></span>
                    <span class="sub-text"><?php echo $admin['phone_number'] ?></span>
                </div>
            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner p-0">
            <ul class="link-list-menu">
                <li><a href="/moha/admin/profile.php"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                <li><a href="/moha/admin/security.php"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
            </ul>
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div><!-- card-aside -->