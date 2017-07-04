<?php
$page = basename($_SERVER['PHP_SELF']);
?>
<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li <?= ($page=='index.php') ? 'class="active"' : ''; ?>><a href="index">Overview</a></li>
        <?php if($data->signedIn): ?>
            <li <?= ($page=='domain.php') ? 'class="active"' : ''; ?>><a href="domain">Domains</a></li>
            <li <?= ($page=='email.php') ? 'class="active"' : ''; ?>><a href="email">Email</a></li>
            <li><a href="#" disabled="true" class="text-muted">File Manager</a></li>
            <li><a href="#" disabled="true" class="text-muted">Profile</a></li>
        <?php endif; ?>
    </ul>
    <?php if($data->isAdmin()): ?>
    <ul class="nav nav-sidebar">
        <li><a href="admin">Admin Panel</a></li>
        <li><a href="admin?users">Admin - Users</a></li>
        <li><a href="admin?domains">Admin - Domains</a></li>
    </ul>
    <?php endif; ?>
</div>