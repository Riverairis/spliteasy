<?php
session_start();
require_once '../controllers/AuthController.php';
require_once '../controllers/BillController.php';
require_once '../controllers/DashboardController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    case 'register':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->register($_POST);
        require_once '../views/auth/register.php';
        break;
    case 'login':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->login($_POST);
        require_once '../views/auth/login.php';
        break;
    case 'forgot_password':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->forgotPassword($_POST);
        require_once '../views/auth/forgot_password.php';
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'verify_email':
        $controller = new AuthController();
        if (!isset($_GET['token']) || empty($_GET['token'])) {
            $error = "No verification token provided.";
            require_once '../views/auth/login.php';
        } else {
            $controller->verifyEmail($_GET['token']);
        }
        break;
    case 'dashboard':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit; }
        $controller = new DashboardController();
        $controller->index();
        break;
    case 'bills':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit; }
        $controller = new DashboardController();
        $controller->bills();
        break;
    case 'create_bill':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit; }
        $controller = new BillController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->create($_POST);
        require_once '../views/dashboard/create_bill.php';
        break;
    case 'view_bill':
        $controller = new BillController();
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?page=dashboard&error=No bill ID specified");
            exit;
        }
        $controller->viewBill($_GET['id']);
        break;
    case 'add_expense':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit; }
        $controller = new BillController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->addExpense($_POST);
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?page=dashboard&error=No bill ID specified");
            exit;
        }
        $controller->viewBill($_GET['id']);
        break;
    case 'add_participant':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit; }
        $controller = new BillController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->addParticipant($_POST);
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?page=dashboard&error=No bill ID specified");
            exit;
        }
        $controller->viewBill($_GET['id']);
        break;
    case 'archive':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit; }
        $controller = new DashboardController();
        $controller->archive();
        break;
    case 'archive_bill':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit; }
        $controller = new BillController();
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?page=archive&error=No bill ID specified");
            exit;
        }
        $controller->archive($_GET['id']);
        break;
    case 'view_guest':
        $controller = new BillController();
        if (!isset($_GET['code']) || empty($_GET['code'])) {
            header("Location: index.php?page=login&error=No invite code specified");
            exit;
        }
        $controller->viewGuest($_GET['code']);
        break;
    default:
        require_once '../views/auth/login.php';
}