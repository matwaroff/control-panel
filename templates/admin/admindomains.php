<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php include "templates/status.php"; ?>
    <h1 class="page-header">Admin Panel</h1>
    <h3 class="page-header">Domains</h3>
    <div class="table-responsive">
        <table class="table table-striped domain-table">
            <thead>
            <tr>
                <th>Domain Name</th>
                <th>Owner</th>
                <th>Actions</th>
            </tr>
            </thead>
            <?php
            $domains = $data->getDomains(true);
            $users = $data->getUsers();
            foreach ($domains as $d) {
                ?>
                <tr>
                    <td class="domain-name">
                        <a href="domain.php?id=<?= hash("md5", $d['domainID']); ?>"><?= $d['domainName']; ?></a>
                    </td>
                    <form method="post" action="admin.php?domains&edit">
                        <input type="hidden" name="editowner" value="<?= $d['domainID']; ?>">
                        <td class="owner"><span class="username"></span> <?= $d['username']; ?>
                            <select class="select-user" name="domain-user-select">
                                <?php foreach($users as $u): ?>
                                    <option value="<?= $u['id']; ?>"><?= $u['username']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                    </form>
                    <td class="actions">
                        <a href="domain.php?id=<?= hash("md5", $d['domainID']); ?>">
                            <button class="btn btn-sm btn-primary">Edit</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>