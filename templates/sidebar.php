<?php
$page = basename($_SERVER['PHP_SELF']);
?>
<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li <?= ($page=='index.php') ? 'class="active"' : ''; ?>><a href="index.php">Overview</a></li>
        <li <?= ($page=='domain.php') ? 'class="active"' : ''; ?>><a href="domain.php">Domains</a></li>
        <li <?= ($page=='email.php') ? 'class="active"' : ''; ?>><a href="email.php">Email</a></li>
        <li><a href="#">File Manager</a></li>
        <li><a href="#">Profile</a></li>
    </ul>
    <?php if($data->isAdmin()): ?>
    <ul class="nav nav-sidebar">
        <li><a href="admin.php">Admin Panel</a></li>
        <li><a href="admin.php?users">Admin - Users</a></li>
        <li><a href="admin.php?domains">Admin - Domains</a></li>
    </ul>
    <?php endif; ?>
</div>