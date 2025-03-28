<?php
class DashboardController {
    private $db, $bill, $user;

    public function __construct() {
        require_once '../config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
        require_once '../models/Bill.php';
        require_once '../models/User.php';
        $this->bill = new Bill($this->db);
        $this->user = new User($this->db);
    }

    public function index() {
        // Removed session_start() here since it's already in index.php
        $bills = $this->bill->getUserBills($_SESSION['user_id']);
        require_once '../views/dashboard/index.php';
    }

    public function bills() {
        // Removed session_start() here
        $bills = $this->bill->getUserBills($_SESSION['user_id']);
        require_once '../views/dashboard/bills.php';
    }

    public function archive() {
        // Removed session_start() here
        $archived_bills = $this->bill->getArchivedBills($_SESSION['user_id']);
        require_once '../views/dashboard/archive.php';
    }
}