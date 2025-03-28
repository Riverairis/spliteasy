<?php
class AuthController {
    private $db, $user;

    public function __construct() {
        require_once '../config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
        require_once '../models/User.php';
        $this->user = new User($this->db);
    }

    public function register($post) {
        $this->user->last_name = $post['last_name'];
        $this->user->first_name = $post['first_name'];
        $this->user->nickname = $post['nickname'];
        $this->user->email = $post['email'];
        $this->user->username = $post['username'];
        $this->user->password = $post['password'];

        if ($post['password'] !== $post['confirm_password']) {
            $error = "Passwords do not match.";
            require_once '../views/auth/register.php';
            return;
        }

        if ($this->user->register()) {
            mail($this->user->email, "Welcome to SplitEasy!", 
                 "Congrats, {$this->user->first_name}! Login here: http://localhost/SplitEasy/public/index.php?page=login", 
                 "From: no-reply@spliteasy.com");
            header("Location: index.php?page=login&success=Registration successful!");
        } else {
            $error = "Registration failed. Check your inputs (e.g., unique nickname/username/email required).";
            require_once '../views/auth/register.php';
        }
    }

    public function login($post) {
        $this->user->username = $post['username'];
        $this->user->password = $post['password'];

        if ($this->user->login()) {
            // Removed session_start() here
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['account_type'] = $this->user->account_type;
            $_SESSION['nickname'] = $this->user->nickname;
            header("Location: index.php?page=dashboard");
        } else {
            $error = "Invalid username or password.";
            require_once '../views/auth/login.php';
        }
    }

    public function logout() {
        // Removed session_start() here
        session_destroy();
        header("Location: index.php?page=login");
    }

    public function forgotPassword($post) {
        $error = "Password reset not implemented yet. Contact support.";
        require_once '../views/auth/forgot_password.php';
    }
}