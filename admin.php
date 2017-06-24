<?php
require 'includes/cpanel.php';
session_start();
$data = isset($_SESSION['cpanel']) ? $_SESSION['cpanel'] : new cpanel();
$data->connect();
if(!$data->canAccess() || !$data->isAdmin()){
    header("Location: restricted.php");
}
if(array_key_exists('adminSettings', $_POST)){
    foreach(array_keys($_POST) as $key){
        if($key == 'adminSettings') continue;
        $cleanPost = $data->conn->real_escape_string(chop($_POST[$key]));
        $data->updateSetting($key, $cleanPost);
    }
}

if(isset($_GET['users'])){
    $adminpage = 1;
    if(isset($_GET['delete'])){
        $data->deleteUser($_GET['delete']);
    }
}
else if(isset($_GET['domains'])){
    $adminpage = 2;
}else{
    $adminpage = 0;
}

if(isset($_GET['adduser']) && isset($_POST['username'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $data->addUser($user,$pass,$fname,$lname,$email);
}

if(isset($_GET['users']) && isset($_GET['activate'])){
    $data->activateUser($_POST['userid']);
}
?>
<html>
<head>
    <?php include "templates/includes.php"; ?>
</head>
<body>
<?php include "templates/header.php"; ?>

<div class="container-fluid admin">
    <div class="row">
        <?php include "templates/sidebar.php"; ?>
        <?php if($adminpage==0):
                include "templates/admin/adminsettings.php";
            elseif($adminpage==1):
                include "templates/admin/adminusers.php";
            elseif($adminpage==2):
                include "templates/admin/admindomains.php";
        endif; ?>
    </div>
</div>
</body>
</html>

