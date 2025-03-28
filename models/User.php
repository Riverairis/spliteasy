<?php
class User {
    private $conn;
    private $table = "users";

    public $id, $last_name, $first_name, $nickname, $email, $username, $password, $account_type;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function register() {
        if (!$this->validate()) return false;

        $query = "INSERT INTO " . $this->table . " 
                  (last_name, first_name, nickname, email, username, password, account_type) 
                  VALUES (:last_name, :first_name, :nickname, :email, :username, :password, :account_type)";
        
        $stmt = $this->conn->prepare($query);
        $this->sanitize();
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->account_type = 'standard';

        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':nickname', $this->nickname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':account_type', $this->account_type);

        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($this->password, $row['password'])) {
            $this->id = $row['id'];
            $this->account_type = $row['account_type'];
            $this->nickname = $row['nickname'];
            return true;
        }
        return false;
    }

    public function upgradeToPremium() {
        $query = "UPDATE " . $this->table . " SET account_type = 'premium' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function validate() {
        if (strlen($this->password) < 8 || strlen($this->password) > 16) return false;
        if (!preg_match('/[A-Z]/', $this->password) || !preg_match('/[a-z]/', $this->password) || 
            !preg_match('/[0-9]/', $this->password) || !preg_match('/[!@#$%^&*]/', $this->password)) return false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) return false;
        if (empty($this->last_name) || empty($this->first_name) || empty($this->nickname) || empty($this->username)) return false;
        return true;
    }

    private function sanitize() {
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->nickname = htmlspecialchars(strip_tags($this->nickname));
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        $this->username = htmlspecialchars(strip_tags($this->username));
    }
}