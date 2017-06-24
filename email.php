<?php
require 'includes/cpanel.php';
require 'includes/mailinabox.php';
session_start();
$data = isset($_SESSION['cpanel']) ? $_SESSION['cpanel'] : new cpanel();
$data->connect();
if(!$data->canAccess()){
    header("Location: restricted.php?test");
}
$mail = new mailinabox($data->getSetting('mailinabox'), $data);
if(isset($_GET['edit'])){
    $editemail = $_GET['edit'];
    if(!$data->isMyDomain(explode("@", $_GET['edit'])[1])){
        header("Location: restricted.php");
    }

}else $editemail = false;

if(isset($_GET['delete'])){
    $delete = $_GET['delete'];
    if(!$data->isMyDomain(explode("@", $_GET['delete'])[1])){
        header("Location: restricted.php");
    }
}else $delete = false;

if(isset($_POST['delete-confirm'])){
    $email = $_POST['deleting-email'];
    if($data->isMyDomain(explode("@", $email)[1])){
        $mail->removeUser($email);
    }
}

if(isset($_POST['newPass'])){

    $newpass = $data->conn->real_escape_string(chop($_POST['newPass']));
    if(($status = $mail->updateUser($_POST['user'], $newpass)['output']) == OK){
        $data->setStatus("Update Password Successful");
    }else{
        $data->setStatus("ERROR: $status", true);
    }

}
if(isset($_POST['newemail'])){
    $email = $data->conn->real_escape_string(chop($_POST['newemail']));
    $pass = $data->conn->real_escape_string(chop($_POST['password']));
    $email = $email . "@" . $_POST['domain'];
    $mail->newUser($email, $pass);
}
?>
<html>
<head>
    <?php include "templates/includes.php"; ?>
</head>
<body>
<?php include "templates/header.php"; ?>

<div class="container-fluid email">
    <div class="row">
        <?php include "templates/sidebar.php"; ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php include "templates/status.php"; ?>
            <h1 class="page-header">Email</h1>
            <?php if(!$editemail && !$delete): ?>
                <div class="container">
                    <h3>Instructions</h3>
                    <div class="row instructions">
                        <div class="col-sm-6 col-xs-12">
                            <ul>
                                <li><b>Protocol:</b> IMAP</li>
                                <li><b>Email Server:</b> <?= $data->getSetting('emailserver'); ?></li>
                                <li><b>IMAP Port:</b> 993</li>
                                <li><b>IMAP Security:</b> SSL or TLS</li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <ul>
                                <li><b>SMTP Port:</b> 587</li>
                                <li><b>SMTP Security:</b> STARTTLS ("Always")</li>
                                <li><b>Username:</b> Your whole email address.</li>
                                <li><b>Password:</b> Your email password.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="table-responsive">
                <table class="table table-striped" id="accordian">
                    <thead>
                    <tr>
                        <th>Domain Name</th>
                        <th>Num. Emails</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $domains = $data->getDomains();
                        foreach ($domains as $d):
                            $friendlydomain = str_replace(".", "-", $d['domainName']);
                            $users = $mail->emailsRequest($d['domainName'])['output'];
                            ?>
                            <tr data-toggle="collapse" data-parent="#accordian" data-target="#accordian-<?= $friendlydomain; ?>" class="clickable-row">
                                <td><?= $d['domainName']; ?></td>
                                <td><?= count($users); ?></td>
                            </tr>
                            <tr id="accordian-<?= $friendlydomain; ?>" class="collapse">
                                <td colspan="2">
                                    <table class="table table-responsive">
                                        <?php
                                            foreach($users as $user):?>
                                                <tr>
                                                    <td><?= $user; ?></td>
                                                    <td class="email-buttons">
                                                        <a href="?edit=<?= $user; ?>"><button class="btn btn-primary btn-sm">Change Password</button></a>
                                                        <a href="?delete=<?= $user; ?>"><button class="btn btn-danger btn-sm">Delete Email</button></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="2">
                                                    <p class="text-muted">Add New Email:</p>
                                                    <form class="form-inline" method="post" action="" autocomplete="off">
                                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="text" class="form-control" placeholder="User" name="newemail">
                                                            <span class="input-group-addon">@<?=$d['domainName'];?></span>
                                                        </div>
                                                            <input type="password" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Password" name="password">
                                                        <input type="hidden" value="<?=$d['domainName'];?>" name="domain">
                                                        <input type="submit" class="btn-primary btn" value="Add User">
                                                    </form>
                                                </td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php elseif(!$delete && $editemail): ?>
                <h4><?= $editemail; ?></h4>
                <h5 class="page-header text-muted">Change Password</h5>
                <form method="post" action="email.php" class="editemail">
                    <div class="input-group">
                        <span class="input-group-addon">New Password:</span>
                        <input type="password" class="form-control pass" placeholder="New Password" name="newPass" value="">
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon">Validate Password:</span>
                        <input type="password" class="form-control validate" placeholder="Validate Password" name="validatePass" value="">
                    </div><br>
                    <input type="hidden" value="<?= $editemail; ?>" name="user">
                    <input type="submit" value="Update" class="btn btn-primary">
                </form>
            <?php elseif($delete && !$editemail): ?>
                    <h4 class="page-header">Delete Email - <?= $delete; ?></h4>
                    <p>Are you sure you want to delete:</p>
                    <span><?=$delete;?></span>
                    <form action="email.php" method="post">
                        <input type="hidden" value="<?=$delete;?>" name="deleting-email">
                        <input type="submit" name="delete-confirm" class="btn btn-danger btn-lg" value="Delete Email">
                    </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
