<?php
require 'includes/cpanel.php';
session_start();
$data = isset($_SESSION['cpanel']) ? $_SESSION['cpanel'] : new cpanel();
$data->connect();
?>
<html>
<head>
    <?php include "templates/includes.php"; ?>
</head>
<body>
<?php include "templates/header.php"; ?>

<div class="container-fluid home">
    <div class="row">
        <?php include "templates/sidebar.php"; ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">No Access</h1>
            <p>You do not have access to this page. Please log-in.</p>
        </div>
    </div>
</div>
</body>
</html>

