<?php
require_once "../config/database.php";

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementFailedAttempts($username)
    {
        $stmt = $this->conn->prepare("UPDATE users SET failed_attempts = failed_attempts + 1 WHERE username = ?");
        $stmt->execute([$username]);
    }

    public function resetFailedAttempts($username)
    {
        $stmt = $this->conn->prepare("UPDATE users SET failed_attempts = 0 WHERE username = ?");
        $stmt->execute([$username]);
    }
}
?>