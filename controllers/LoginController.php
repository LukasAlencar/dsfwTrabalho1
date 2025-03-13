<?php
require_once "../config/database.php";
require_once "../models/User.php";
session_start();

class LoginController
{
    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->getUserByUsername($username);

            if ($user) {
                if ($user['failed_attempts'] >= 3) {
                    $_SESSION['error_message'] = "Usuário bloqueado. Entre em contato com o administrador.";
                    header("Location: ../views/login.php");
                    exit;
                }

                if ($password === $user['password']) {
                    $_SESSION['user_id'] = $user;
                    $userModel->resetFailedAttempts($username);

                    if ($user['role'] == 'aluno') {
                        header("Location: ../views/aluno.php");
                    } else {
                        header("Location: ../views/professor.php");
                    }
                    exit;
                } else {
                    $userModel->incrementFailedAttempts($username);
                    $_SESSION['error_message'] = "Usuário ou senha incorretos.";
                    header("Location: ../views/login.php");
                    exit;
                }
            } else {
                $_SESSION['error_message'] = "Usuário não encontrado.";
                header("Location: ../views/login.php");
                exit;
            }
        }
    }
}


$controller = new LoginController();
$controller->index();
?>
