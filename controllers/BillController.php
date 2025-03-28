<?php
class BillController {
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

    public function create($post) {
        $this->bill->user_id = $_SESSION['user_id'];
        $this->bill->bill_name = $post['bill_name'];

        if ($_SESSION['account_type'] === 'standard') {
            if ($this->bill->countBillsThisMonth($this->bill->user_id) >= 5) {
                $error = "Standard users can only create 5 bills per month.";
                require_once '../views/dashboard/create_bill.php';
                return;
            }
        }

        $bill_id = $this->bill->create();
        if ($bill_id) {
            header("Location: index.php?page=view_bill&id=$bill_id");
        } else {
            $error = "Failed to create bill.";
            require_once '../views/dashboard/create_bill.php';
        }
    }

    public function addParticipant($post) {
        if (!isset($post['bill_id']) || empty($post['bill_id'])) {
            $error = "Invalid bill ID.";
            $this->viewBill(null); // Redirect to a safe state
            return;
        }

        $bill_id = $post['bill_id'];
        $bill_exists = $this->bill->getById($bill_id);

        if (!$bill_exists) {
            $error = "Bill does not exist.";
            $this->viewBill($bill_id);
            return;
        }

        $participants = $this->bill->getParticipants($bill_id);

        if ($_SESSION['account_type'] === 'standard' && count($participants) >= 3) {
            $error = "Standard users can only add up to 3 participants per bill.";
            $this->viewBill($bill_id);
            return;
        }

        try {
            if (isset($post['user_id']) && !empty($post['user_id'])) {
                $query = "INSERT INTO bill_participants (bill_id, user_id) VALUES (:bill_id, :user_id)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':bill_id', $bill_id);
                $stmt->bindParam(':user_id', $post['user_id']);
                $stmt->execute();
            } elseif (isset($post['guest_email']) && !empty($post['guest_email'])) {
                $query = "INSERT INTO bill_participants (bill_id, guest_email, guest_name) 
                          VALUES (:bill_id, :guest_email, :guest_name)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':bill_id', $bill_id);
                $stmt->bindParam(':guest_email', $post['guest_email']);
                $stmt->bindParam(':guest_name', $post['guest_name']);
                $stmt->execute();
            } else {
                $error = "Please provide a user or guest email.";
                $this->viewBill($bill_id);
                return;
            }
            header("Location: index.php?page=view_bill&id=$bill_id");
        } catch (PDOException $e) {
            $error = "Failed to add participant: " . $e->getMessage();
            $this->viewBill($bill_id);
        }
    }

    public function archive($bill_id) {
        $this->bill->user_id = $_SESSION['user_id'];
        if ($this->bill->archive($bill_id)) {
            header("Location: index.php?page=archive");
        }
    }

    public function addExpense($post) {
        require_once '../models/Expense.php';
        $expense = new Expense($this->db);
        $expense->bill_id = $post['bill_id'];
        $expense->expense_name = $post['expense_name'];
        $expense->paid_by = $_SESSION['user_id'];
        $expense->amount = $post['amount'];
        $expense->split_type = $post['split_type'];

        if ($expense->create()) {
            header("Location: index.php?page=view_bill&id=" . $post['bill_id']);
        } else {
            $error = "Failed to add expense. Ensure there are participants in the bill.";
            $this->viewBill($post['bill_id']);
        }
    }

    public function viewGuest($code) {
        $bill = $this->bill->getByInviteCode($code);
        if ($bill) {
            $this->viewBill($bill['id']);
        } else {
            $error = "Invalid invite code.";
            require_once '../views/auth/login.php';
        }
    }

    public function viewBill($bill_id) {
        require_once '../models/Expense.php';
        require_once '../models/User.php';
        $bill_model = new Bill($this->db);
        $expense_model = new Expense($this->db);
        $user_model = new User($this->db);

        $bill = $bill_id ? $bill_model->getById($bill_id) : null;
        $expenses = $bill_id ? $expense_model->getByBill($bill_id) : [];
        $participants = $bill_id ? $bill_model->getParticipants($bill_id) : [];
        $all_users = $this->db->query("SELECT id, nickname FROM users")->fetchAll(PDO::FETCH_ASSOC);

        require_once '../views/dashboard/view_bill.php';
    }
}