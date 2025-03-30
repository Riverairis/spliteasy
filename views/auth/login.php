<?php include '../views/layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center">Login to SplitEasy</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php elseif (isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
                <?php endif; ?>
                <form method="POST" action="index.php?page=login">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3">
                    <a href="index.php?page=forgot_password">Forgot Password?</a> | 
                    <a href="index.php?page=register">Register</a>
                </p>
                <p class="text-center">Guest? Enter invite code:</p>
                <form method="GET" action="index.php?page=view_guest" class="d-flex justify-content-center">
                    <input type="text" name="code" class="form-control w-50 me-2" placeholder="Invite Code" required>
                    <button type="submit" class="btn btn-secondary">View</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../views/layouts/footer.php'; ?>