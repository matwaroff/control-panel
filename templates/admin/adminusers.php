<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php include "templates/status.php"; ?>
    <h1 class="page-header">Admin Panel</h1>
    <h3 class="page-header">Users</h3>
    <table class="table-responsive table">
        <thead>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Admin?</th>
        <th colspan="2"></th>
        </thead>
        <tbody>
        <?php
        $users = $data->getUsers();
        foreach($users as $user):?>
            <tr>
                <td><?= $user['id']; ?></td>
                <td><?= $user['username']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['firstName']; ?></td>
                <td><?= $user['lastName']; ?></td>
                <td><input type="checkbox" class="checkbox-inline" <?= ($user['permission'] == 99) ? checked : null; ?> disabled></td>
                <td>
                    <form action="admin.php?users&delete=<?= $user['id']; ?>" method="post">
                        <input type="hidden" name="userid" value="<?= $user['id']; ?>">
                        <input type="submit" name="deleteuser" class="btn btn-danger btn-sm" value="Delete">
                    </form>
                    <?php if(!$data->isActivated($user['id'])): ?>
                    <form action="admin.php?users&activate" method="post">
                        <input type="hidden" name="userid" value="<?= $user['id']; ?>">
                        <input type="submit" name="activateuser" class="btn btn-primary btn-sm" value="Activate">
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <table class="table table-responsive">
        <form action="admin.php?users&adduser" method="post">
            <tr>
                <span class="text-muted">New User:</span>
                <td></td>
                <td><input class="form-control" type="text" name="username" placeholder="Username" required></td>
                <td><input class="form-control" type="password" name="password" placeholder="Password" required></td>
                <td><input class="form-control" type="email" name="email" placeholder="Email" required></td>
                <td><input class="form-control" type="text" name="firstName" placeholder="First Name" required></td>
                <td><input class="form-control" type="text" name="lastName" placeholder="Last Name" required></td>
                <td><label class="control-label" for="admin">Admin:</label> <input class="checkbox-inline checkbox" type="checkbox" name="admin"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="6"><button class="btn btn-primary btn-lg">Add User</button></td>
            </tr>
        </form>
    </table>
</div>