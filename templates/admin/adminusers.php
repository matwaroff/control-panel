<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php include "templates/status.php"; ?>
    <h1 class="page-header">Admin Panel</h1>
    <?php if($confirmdelete): ?>
        <h4>Confirm Delete</h4>
        <h5>This will delete <b><?= $_POST['useremail']; ?></b> <small>Are you sure?</small></h5>
        <form method="post" action="">
            <input type="hidden" name="deleteconfirm" value="1">
            <input type="submit" class="btn btn-warning" value="Delete">
        </form>
        <a href="admin?users"><button class="btn btn-success">Go back.</button></a>
    <?php endif; ?>
    <h3 class="page-header">Users</h3>
    <table class="table-responsive table">
        <thead>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Name</th>
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
                <td><?= $user['lastName'] . ", " . $user['firstName']; ?></td>
                <td class="adminbox"><span<?= ($user['permission'] == 99) ? " class='glyphicon glyphicon-ok'>" : ">" ?> </span></td>
                <td>
                    <form action="admin?users&delete=<?= $user['id']; ?>" method="post">
                        <input type="hidden" name="userid" value="<?= $user['id']; ?>">
                        <input type="hidden" name="useremail" value="<?= $user['email']; ?>">
                        <input type="submit" name="deleteuser" class="btn btn-danger btn-sm" value="Delete">
                    </form>
                    <?php if(!$data->isActivated($user['id'])): ?>
                    <form action="admin?users&activate" method="post">
                        <input type="hidden" name="userid" value="<?= $user['id']; ?>">
                        <input type="submit" name="activateuser" class="btn btn-primary btn-sm" value="Activate">
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <form action="admin?users&adduser" method="post" class="text-center center-block new-user">
        <span class="text-muted">New User</span>
        <div class="form-group text-left">
            <label for="username">Username</label>
            <input class="form-control" type="text" name="username" placeholder="Username" required>
        </div>
        <div class="form-group text-left">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group text-left">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group text-left">
            <label for="firstName">Name</label>
            <input class="form-control" type="text" name="firstName" placeholder="First Name" required>
            <input class="form-control" type="text" name="lastName" placeholder="Last Name" required>
        </div>
        <label class="control-label" for="admin">Admin:</label> <input class="checkbox-inline checkbox" type="checkbox" name="admin">
        <td colspan="6"><button class="btn btn-primary btn-lg">Add User</button>
    </form>
</div>