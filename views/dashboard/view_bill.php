<?php include '../views/layouts/header.php'; ?>

<?php if (!is_array($bill) || empty($bill)): ?>
    <div class="alert alert-danger">Bill not found or invalid bill ID.</div>
<?php else: ?>
    <h2 class="mb-4"><?php echo htmlspecialchars($bill['bill_name']); ?></h2>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Invite Code:</strong> <?php echo htmlspecialchars($bill['invite_code']); ?> 
                <button class="btn btn-sm btn-secondary" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($bill['invite_code']); ?>')">Copy</button>
            </p>
            <p><strong>Created:</strong> <?php echo date('M d, Y', strtotime($bill['created_at'])); ?></p>
        </div>
    </div>

    <h3>Expenses</h3>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (empty($expenses)): ?>
                <p class="text-muted">No details</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Paid By</th>
                                <th>Split Type</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expenses as $exp): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($exp['expense_name']); ?></td>
                                    <td>$<?php echo number_format($exp['amount'], 2); ?></td>
                                    <td>
                                        <?php 
                                        $paid_by_user = $user_model->getById($exp['paid_by']);
                                        echo $paid_by_user ? htmlspecialchars($paid_by_user['nickname']) : 'Unknown User';
                                        ?>
                                    </td>
                                    <td><?php echo ucfirst(htmlspecialchars($exp['split_type'])); ?></td>
                                    <td>
                                        <?php 
                                        $splits = $expense_model->getSplits($exp['id']);
                                        if (!is_array($splits) || empty($splits)): ?>
                                            <p>No splits available</p>
                                        <?php else: ?>
                                            <ul>
                                                <?php foreach ($splits as $split): ?>
                                                    <li>
                                                        <?php 
                                                        echo $split['user_id'] 
                                                            ? htmlspecialchars($user_model->getById($split['user_id'])['nickname'] ?? 'Unknown') 
                                                            : htmlspecialchars($split['guest_email'] ?? 'Unknown Guest'); 
                                                        ?>: $<?php echo number_format($split['amount'], 2); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id']) && $bill['user_id'] == $_SESSION['user_id']): ?>
                <form method="POST" action="index.php?page=add_expense" class="mt-3">
                    <input type="hidden" name="bill_id" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="expense_name" class="form-control" placeholder="Expense Name" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="number" name="amount" class="form-control" placeholder="Amount" step="0.01" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <select name="split_type" class="form-select">
                                <option value="equally">Equally Divided</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Add</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <h3>Participants</h3>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($participants)): ?>
                <p class="text-muted">No participants yet</p>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($participants as $participant): ?>
                        <li class="list-group-item">
                            <?php 
                            echo $participant['user_id'] 
                                ? htmlspecialchars($user_model->getById($participant['user_id'])['nickname'] ?? 'Unknown') 
                                : htmlspecialchars($participant['guest_name'] . " (" . $participant['guest_email'] . ")"); 
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id']) && $bill['user_id'] == $_SESSION['user_id']): ?>
                <form method="POST" action="index.php?page=add_participant" class="mt-3">
                    <input type="hidden" name="bill_id" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <select name="user_id" class="form-select">
                                <option value="">Select Registered User</option>
                                <?php foreach ($all_users as $user): ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['nickname']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="email" name="guest_email" class="form-control" placeholder="Guest Email">
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" name="guest_name" class="form-control" placeholder="Guest Name">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">Add</button>
                        </div>
                    </div>
                    <small class="text-muted">Leave user dropdown empty to add a guest.</small>
                </form>
            <?php endif; ?>
        </div>
    </div>

       <!-- Archive Button (Host Only) -->
       <?php if (isset($_SESSION['user_id']) && $bill['user_id'] == $_SESSION['user_id'] && !$bill['is_archived']): ?>
        <a href="index.php?page=archive_bill&id=<?php echo $bill['id']; ?>" class="btn btn-warning mb-4">Archive Bill</a>
    <?php endif; ?>
<?php endif; ?>


<?php include '../views/layouts/footer.php'; ?>