<?php
require_once "../config/database.php";
require_once "../models/User.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role']; // 'Aluno' ou 'Professor'

    session_start();

    if (User::usernameExists($username)) {
        echo 'Nome de usuário já existe.';
        header("Location: ../views/register.php");
        $_SESSION['error_message'] = "Nome de usuário já existe.";
        exit;
    }


    $user = new User($username, $password, $role);

    if ($user->save()) {
        header("Location: ../views/login.php");
        exit;
    } else {
        echo "Erro ao registrar usuário.";
    }
}

?>
