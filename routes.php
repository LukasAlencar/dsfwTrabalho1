<?php
require_once "config/SessionManager.php";
require_once "controllers/LoginController.php";

SessionManager::startSession();

$route = $_GET['route'] ?? 'login';

$routes = [
    'login' => 'controllers/LoginController.php',
    'professor' => 'views/professor.php',
    'aluno' => 'views/aluno.php',
    'logout' => 'controllers/LogoutController.php'
];

if (array_key_exists($route, $routes)) {
    require_once $routes[$route];
} else {
    http_response_code(404);
    echo "<h1>Página não encontrada</h1>";
}
?>
