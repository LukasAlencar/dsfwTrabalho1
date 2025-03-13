<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Você precisa fazer login para acessar esta página.";
    header("Location: ../views/login.php");
    exit();
} else if ($_SESSION['user_id']['role'] !== 'aluno') {
    $_SESSION['error_message'] = "Você não tem acesso a essa página.";
    header("Location: " . 'professor.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Aluno</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body style="background-color: #62c47c;">

    <div class="modal d-flex justify-content-center align-items-center" tabindex="10">
        <div class="modal-dialog w-50">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Aluno: 
                        <?php
                            echo $_SESSION['user_id']['username'];
                        ?>
                    </h5>
                </div>
                <div class="modal-body">
                    <p>Bem vindo!</p>
                    <?php
                    if (isset($_SESSION['error_message'])) {
                        echo '<div id="error-message" style="color: #f54966" class=" text-start mb-2">' . $_SESSION['error_message'] . '</div>';
                        unset($_SESSION['error_message']);
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <a href="../controllers/LogoutController.php" class="btn btn-danger">Sair</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            setTimeout(function () {
                setTimeout(function () {
                    var errorMessage = document.getElementById("error-message");
                    if (errorMessage) {
                        errorMessage.style.display = "none";
                    }
                }, 3000);
            }, 100);


        });
    </script>
</body>

</html>