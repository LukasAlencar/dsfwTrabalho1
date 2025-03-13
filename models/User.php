<?php
require_once "../config/database.php";

class User
{
    private $conn;
    private $username;
    private $password;
    private $role;

    public function __construct($username = null, $password = null, $role = null)
    {
        $this->conn = Database::getConnection();

        if ($username !== null && $password !== null && $role !== null) {
            $this->username = $username;
            $this->password = $password;
            $this->role = $role;
        }
    }

    public static function usernameExists($username) {
        $conn = Database::getConnection();
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function save() {
        try {
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserByUsername($username)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function incrementFailedAttempts($username)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET failed_attempts = failed_attempts + 1 WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
        }
    }

    public function resetFailedAttempts($username)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET failed_attempts = 0 WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
        }
    }
}
?>
