<?php include '../views/layouts/header.php'; ?>
<div class="row">
    <div class="col">
        <h2 class="mb-4">Dashboard</h2>
        <div class="card shadow">
            <div class="card-body">
                <h5>Welcome, <?php echo $_SESSION['nickname']; ?>!</h5>
                <p>Account Type: <?php echo ucfirst($_SESSION['account_type']); ?></p>
                <?php if ($_SESSION['account_type'] === 'standard'): ?>
                    <a href="#" class="btn btn-warning">Upgrade to Premium</a>
                <?php endif; ?>
                <a href="index.php?page=create_bill" class="btn btn-success ms-2">Create New Bill</a>
            </div>
        </div>
        <h3 class="mt-4">Recent Bills</h3>
        <?php if (empty($bills)): ?>
            <div class="alert alert-info">No bills yet. <a href="index.php?page=create_bill">Create one now!</a></div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Invite Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bills as $bill): ?>
                            <tr>
                                <td><?php echo $bill['bill_name']; ?></td>
                                <td><?php echo $bill['invite_code']; ?></td>
                                <td>
                                    <a href="index.php?page=view_bill&id=<?php echo $bill['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                    <a href="index.php?page=archive_bill&id=<?php echo $bill['id']; ?>" class="btn btn-sm btn-warning">Archive</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include '../views/layouts/footer.php'; ?>