<?php
    require "includes/cpanel.php";

    $data = new cpanel();
    $data->connect();

    if(isset($_GET['request']))
        $register = true;
    else $register = false;

?>
<html>
    <?php include "templates/includes.php"; ?>
<body>

    <div class="container login">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <?php if(!$register): ?>
                <h1 class="text-center login-title">Sign in to continue to <?= $data->getSetting('siteTitle'); ?></h1>
                <div class="account-wall">
                    <form class="form-signin" action="index.php" method="post">
                        <input type="text" class="form-control" placeholder="Username" required autofocus name="username">
                        <input type="password" class="form-control" placeholder="Password" required name="password">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Sign in</button>

                        <label class="checkbox pull-left">
                            <input type="checkbox" value="remember-me">
                            Remember me
                        </label>
                    </form>
                    <a href="?request" class="text-center new-account">Request Access</a>
                </div>
                <?php else: ?>
                    <h1 class="text-center login-title">Request access to <?= $data->getSetting('siteTitle'); ?></h1>
                    <div class="account-wall">
                        <form class="form-signin" action="index.php?request" method="post">
                            <div class="form-group">
                                <label class="form-control-label" for="newuser">Username</label>
                                <input type="text" class="form-control" placeholder="Username" required autofocus name="newuser" id="newuser">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="newpass">Password</label>
                                <input type="password" class="form-control" placeholder="Password" required name="newpass" id="newpass">
                                <label class="form-control-label" for="verifypass">Verify Password</label>
                                <input type="password" class="form-control" placeholder="Verify Password" required name="verifypass" id="verifypass">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="email">Email</label>
                                <input type="email" class="email form-control" placeholder="Email" required name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="firstName">First Name</label>
                                <input type="text" class="form-control" placeholder="First Name" id="firstName" name="firstName">
                                <label class="form-control-label" for="lastName">Last Name</label>
                                <input type="text" class="form-control" placeholder="Last Name" id="lastName" name="lastName">
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Send Request</button>
                        </form>
                        <a href="login.php" class="text-center new-account">Sign in</a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>


</body>
</html>
