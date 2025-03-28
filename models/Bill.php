<?php
class Bill {
    private $conn;
    private $table = "bills";

    public $id, $user_id, $bill_name, $invite_code, $is_archived;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (user_id, bill_name, invite_code) 
                  VALUES (:user_id, :bill_name, :invite_code)";
        $stmt = $this->conn->prepare($query);
        
        $this->bill_name = htmlspecialchars(strip_tags($this->bill_name));
        $this->invite_code = bin2hex(random_bytes(5));

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':bill_name', $this->bill_name);
        $stmt->bindParam(':invite_code', $this->invite_code);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function getUserBills($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id AND is_archived = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArchivedBills($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id AND is_archived = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function archive($bill_id) {
        $query = "UPDATE " . $this->table . " SET is_archived = 1 WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $bill_id);
        $stmt->bindParam(':user_id', $this->user_id);
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByInviteCode($code) {
        $query = "SELECT * FROM " . $this->table . " WHERE invite_code = :code LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getParticipants($bill_id) {
        $query = "SELECT * FROM bill_participants WHERE bill_id = :bill_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bill_id', $bill_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countBillsThisMonth($user_id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                  WHERE user_id = :user_id AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
                  AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
}