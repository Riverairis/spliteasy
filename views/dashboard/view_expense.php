<?php include '../views/layouts/header.php'; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php elseif (!$expense): ?>
    <div class="alert alert-danger">Expense not found.</div>
<?php else: ?>
    <h2 class="mb-4">Expense: <?php echo htmlspecialchars($expense['expense_name']); ?></h2>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Bill:</strong> <?php echo htmlspecialchars($bill['bill_name']); ?></p>
            <p><strong>Amount:</strong> $<?php echo number_format($expense['amount'], 2); ?></p>
            <p><strong>Paid By:</strong> 
                <?php 
                $paid_by_user = $user_model->getById($expense['paid_by']);
                echo $paid_by_user ? htmlspecialchars($paid_by_user['nickname']) : 'Unknown User';
                ?>
            </p>
            <p><strong>Split Type:</strong> <?php echo ucfirst(htmlspecialchars($expense['split_type'])); ?></p>
        </div>
    </div>

    <!-- Participants and Split Details -->
    <h3>Participants and Split Details</h3>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($participants)): ?>
                <p class="text-muted">No participants in this bill.</p>
            <?php elseif (empty($splits)): ?>
                <p class="text-muted">No split details available for this expense.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Participant</th>
                                <th>Amount Owed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($splits as $split): ?>
                                <tr>
                                    <td>
                                        <?php 
                                        $participant_name = $split['user_id'] 
                                            ? ($user_model->getById($split['user_id'])['nickname'] ?? 'Unknown')
                                            : ($split['guest_email'] ?? 'Unknown Guest');
                                        echo htmlspecialchars($participant_name);
                                        ?>
                                    </td>
                                    <td>$<?php echo number_format($split['amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Back to Bill Button -->
    <a href="index.php?page=view_bill&id=<?php echo $expense['bill_id']; ?>" class="btn btn-secondary">Back to Bill</a>
<?php endif; ?>

<?php include '../views/layouts/footer.php'; ?>