<?php
class Expense {
    private $conn;
    private $table = "expenses";

    public $id, $bill_id, $expense_name, $paid_by, $amount, $split_type;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (bill_id, expense_name, paid_by, amount, split_type) 
                  VALUES (:bill_id, :expense_name, :paid_by, :amount, :split_type)";
        $stmt = $this->conn->prepare($query);

        $this->expense_name = htmlspecialchars(strip_tags($this->expense_name));
        $stmt->bindParam(':bill_id', $this->bill_id);
        $stmt->bindParam(':expense_name', $this->expense_name);
        $stmt->bindParam(':paid_by', $this->paid_by);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':split_type', $this->split_type);

        if ($stmt->execute()) {
            $expense_id = $this->conn->lastInsertId();
            if (!$this->splitExpense($expense_id)) {
                // If split fails (e.g., no participants), rollback the expense creation
                $this->conn->exec("DELETE FROM " . $this->table . " WHERE id = $expense_id");
                return false;
            }
            return true;
        }
        return false;
    }

    private function splitExpense($expense_id) {
        $bill = new Bill($this->conn);
        $participants = $bill->getParticipants($this->bill_id);

        if (empty($participants)) {
            return false; // No participants, cannot split
        }

        $split_amount = $this->split_type === 'equally' ? $this->amount / count($participants) : $this->amount;

        $query = "INSERT INTO expense_splits (expense_id, user_id, guest_email, amount) 
                  VALUES (:expense_id, :user_id, :guest_email, :amount)";
        $stmt = $this->conn->prepare($query);

        foreach ($participants as $participant) {
            $stmt->bindParam(':expense_id', $expense_id);
            $stmt->bindParam(':user_id', $participant['user_id']);
            $stmt->bindParam(':guest_email', $participant['guest_email']);
            $stmt->bindParam(':amount', $split_amount);
            $stmt->execute();
        }
        return true;
    }

    public function getByBill($bill_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE bill_id = :bill_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bill_id', $bill_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSplits($expense_id) {
        $query = "SELECT * FROM expense_splits WHERE expense_id = :expense_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':expense_id', $expense_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}