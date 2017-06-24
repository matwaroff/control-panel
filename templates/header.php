
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><?= $data->getSetting('siteTitle'); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if($data->signedIn): ?>
                    <li><a href="index.php">Dashboard</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="profile.php">Profile</a></li>
                    <?php if($data->isAdmin()): ?>
                        <li><a href="admin.php">Settings</a></li>
                    <?php endif; ?>
                    <li><a href="index.php?logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Sign In</a></li>
                <?php endif; ?>
            </ul>
            <!--            <form class="navbar-form navbar-right">-->
            <!--                <input type="text" class="form-control" placeholder="Search...">-->
            <!--            </form>-->
        </div>
    </div>
</nav>