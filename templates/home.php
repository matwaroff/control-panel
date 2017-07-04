<?php if ($data->signedIn): ?>

    <div class="col-xs-12 col-sm-11 col-sm-offset-1 blue">
        <div class="img-circle user"><?= $data->getInitials(); ?></div>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?php include "templates/status.php"; ?>
        <?php
        if ($data->isAdmin()):
            $numnewusers = $data->newUsers(); ?>
            <a href="admin?users">
                <button class="btn btn-success pull-right" <?= ($numnewusers == 0) ? "disabled" : ""; ?>>
                    <span class="badge pull-right"><?= $numnewusers; ?></span>
                    New Users&nbsp;
                </button>
            </a>
        <?php endif; ?>
        <h1 class="page-header">Dashboard</h1>
        <div class="container circle-links">
            <div class="row">
                <div class="col-sm-3 col-xs-6">
                    <a href="domain">
                        <div class="img-circle circle-link">
                            <span class="glyphicon glyphicon-transfer"></span>
                        </div>
                        <h3>Domains</h3>
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <a href="filemanager">
                        <div class="img-circle circle-link">
                            <span class="glyphicon glyphicon-folder-open"></span>
                        </div>
                        <h3>File Manager</h3>
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <a href="email">
                        <div class="img-circle circle-link">
                            <span class="glyphicon bold">@</span>
                        </div>
                        <h3>Email</h3>
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <a href="admin">
                        <div class="img-circle circle-link">
                            <span class="glyphicon glyphicon-user"></span>
                        </div>
                        <h3>Profile</h3>
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-4 col-sm-push-1 col-xs-12">
                <h3>Owned Domains</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Domain Name</th>
                    </tr>
                    </thead>
                    <?php
                    $domains = $data->getDomains();
                    foreach ($domains as $d):
                        ?>
                        <tr>
                            <td class="domain-name">
                                <a href="domain?id=<?= hash("md5", $d['domainID']); ?>"><?= $d['domainName']; ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-sm-4 col-sm-push-2 col-xs-12">
                <h3>Email</h3>
                <ul class="list-group">
                    <li class="list-group-item"><b>Num Emails: </b><?= $mail->numEmails($domains); ?></li>
                </ul>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-xs-12 main">
        <?php if (isset($_POST['newuser'])): ?>
            <div class="alert alert-info">
                <h4 class="page-header">Access Requested</h4>
                <p>Please check your email in the next 24hrs for an activation confirmation.</p>
            </div>
        <?php endif; ?>
        <h1 class="page-header">Welcome</h1>
        <p>Please log-in to access your dashboard.</p>
        <a href="login">
            <button class="btn btn-primary">Log In</button>
        </a>
    </div>
<?php endif; ?>