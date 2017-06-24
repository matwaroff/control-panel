<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php include "templates/status.php"; ?>
    <h1 class="page-header">Admin Panel</h1>
    <h3 class="page-header">Global Settings</h3>
    <form name="admin-settings" method="post" action="">
        <div class="input-group">
            <span class="input-group-addon">Site Title:</span>
            <input type="text" class="form-control" placeholder="Page Title" name="siteTitle" value="<?= $data->getSetting('siteTitle'); ?>">
        </div><br>
        <input type="hidden" name="adminSettings" value="1">
        <input type="submit" class="btn btn-primary" value="Save">
    </form>
</div>