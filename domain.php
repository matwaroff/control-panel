<?php
require "includes/cpanel.php";
session_start();
$data = isset($_SESSION['cpanel']) ? $_SESSION['cpanel'] : new cpanel();
$data->db();
if (!$data->canAccess()) {
    header("Location: restricted.php");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $domain = $data->getDomain($id);
}else
    $id = false;
?>

<html>
<head>
    <?php include "templates/includes.php"; ?>
</head>
<body>
<?php include "templates/header.php"; ?>

<div class="container-fluid">
    <div class="row">
        <?php include "templates/sidebar.php"; ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php include "templates/status.php"; ?>
            <?php if (!$id): ?>
            <h1 class="page-header">Domains</h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Domain Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <?php
                    $domains = $data->getDomains();
                    foreach ($domains as $d) {
                        ?>
                        <tr>
                            <td><a href="domain.php?id=<?= hash("md5", $d['domainID']); ?>"><?= $d['domainName']; ?></a>
                            </td>
                            <td><a href="domain.php?id=<?= hash("md5", $d['domainID']); ?>">
                                    <button class="btn btn-primary">Edit</button>
                                </a></td>
                        </tr>
                    <?php } ?>

                </table>
            </div>
            <?php else: ?>
                <h1 class="page-header"><?= $domain['domainName']; ?></h1>
                <p>Coming soon...</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
