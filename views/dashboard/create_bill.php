<?php include '../views/layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Create a New Bill</h2>
        <div class="card shadow">
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="index.php?page=create_bill">
                    <div class="mb-3">
                        <label for="bill_name" class="form-label">Bill Name</label>
                        <input type="text" name="bill_name" id="bill_name" class="form-control" placeholder="e.g., Dinner with Friends" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Create Bill</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../views/layouts/footer.php'; ?>