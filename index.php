<?php
require 'includes/cpanel.php';
require 'includes/mailinabox.php';
session_start();
$data = isset($_SESSION['cpanel']) ? $_SESSION['cpanel'] : new cpanel();
$data->connect();
$mail = new mailinabox($data->getSetting('mailinabox'), $data);
if (isset($_GET['logout']) && $data->signedIn == 1) {
    $data->logout();
    header("Location: index.php");
}

if (isset($_POST['username']) && $data->signedIn == 0) {
    $username = $data->conn->real_escape_string(chop($_POST['username']));
    $password = $data->conn->real_escape_string(chop($_POST['password']));
    if ($username != "" && $password != "") {
        try {
            $data->login($username, hash("sha512", $password));
            setcookie("session", hash("md5", $username), time() + 8640000000);
            header("Location: index.php");

        } catch (Exception $e) {
            header("Location: login.php?incorrect");
        }

        $_SESSION['cpanel'] = $data;
    }
}

if (isset($_POST['newuser'])) {
    $newuser = $_POST['newuser'];
    $newpass = $_POST['newpass'];
    $email = $_POST['email'];
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $newid = $data->addUser($newuser, $newpass, $fname, $lname, $email);
}

?>
<html>
<head>
    <?php include "templates/includes.php"; ?>
</head>
<body>
<?php include "templates/header.php"; ?>
<div class="container-fluid home">
    <div class="row">
        <?php
        if($data->signedIn) include "templates/sidebar.php";
        include "templates/home.php";
        ?>
    </div>
</div>
<?php include "templates/footer.php"; ?>
</body>
</html>
