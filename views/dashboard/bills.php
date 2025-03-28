<?php include '../views/layouts/header.php'; ?>
<h2 class="mb-4">Your Bills</h2>
<div class="row">
    <div class="col">
        <?php if (empty($bills)): ?>
            <div class="alert alert-info">No bills yet. <a href="index.php?page=create_bill">Create one now!</a></div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Invite Code</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bills as $bill): ?>
                            <tr>
                                <td><?php echo $bill['bill_name']; ?></td>
                                <td><?php echo $bill['invite_code']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($bill['created_at'])); ?></td>
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
        <a href="index.php?page=create_bill" class="btn btn-success mt-3">Create New Bill</a>
    </div>
</div>
<?php include '../views/layouts/footer.php'; ?>