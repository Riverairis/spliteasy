<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $db, $user;

    public function __construct() {
        require_once '../config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
        require_once '../models/User.php';
        $this->user = new User($this->db);
        require_once '../vendor/autoload.php';
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
            $this->sendVerificationEmail($this->user->email, $this->user->first_name, $this->user->verification_token);
            header("Location: index.php?page=login&success=Registration successful! Please check your email to verify your account.");
        } else {
            $error = "Registration failed. Check your inputs (e.g., unique nickname/username/email required).";
            require_once '../views/auth/register.php';
        }
    }

    private function sendVerificationEmail($toEmail, $firstName, $token) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';              // Specify your SMTP server (e.g., smtp.gmail.com)
            $mail->SMTPAuth   = true;                            // Enable SMTP authentication
            $mail->Username   = 'iris60530@gmail.com';        // SMTP username
            $mail->Password   = 'mjhjkdeoczmaiusn';           // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
            $mail->Port       = 587;   

            $mail->setFrom('no-reply@spliteasy.com', 'SplitEasy Team');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your SplitEasy Account';
            $verifyLink = "http://localhost/SplitEasy/public/index.php?page=verify_email&token=$token";
            $mail->Body    = "
                <h2>Welcome, $firstName!</h2>
                <p>Please verify your email by clicking the link below:</p>
                <p><a href='$verifyLink'>Verify Your Account</a></p>
            ";
            $mail->AltBody = "Welcome, $firstName! Verify your account here: $verifyLink";

            $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send verification email: {$mail->ErrorInfo}");
        }
    }

    public function login($post) {
        $this->user->username = $post['username'];
        $this->user->password = $post['password'];

        $loginResult = $this->user->login();
        if ($loginResult === true) {
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['account_type'] = $this->user->account_type;
            $_SESSION['nickname'] = $this->user->nickname;
            header("Location: index.php?page=dashboard");
        } elseif ($loginResult === 'unverified') {
            $error = "Your account is not verified. Please check your email for the verification link.";
            require_once '../views/auth/login.php';
        } else {
            $error = "Invalid username or password.";
            require_once '../views/auth/login.php';
        }
    }

    public function verify($token) {
        if ($this->user->verify($token)) {
            $success = "Your account has been verified! You can now log in.";
            require_once '../views/auth/login.php';
        } else {
            $error = "Invalid or expired verification token.";
            require_once '../views/auth/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
    }

    public function forgotPassword($post) {
        $error = "Password reset not implemented yet. Contact support.";
        require_once '../views/auth/forgot_password.php';
    }
}
?>