<?php include '../views/layouts/header.php'; ?>
<h2 class="mb-4">Archived Bills</h2>
<div class="row">
    <div class="col">
        <?php if (empty($archived_bills)): ?>
            <div class="alert alert-info">No archived bills.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Invite Code</th>
                            <th>Archived On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($archived_bills as $bill): ?>
                            <tr>
                                <td><?php echo $bill['bill_name']; ?></td>
                                <td><?php echo $bill['invite_code']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($bill['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include '../views/layouts/footer.php'; ?>