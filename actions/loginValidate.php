<?php
include('../includes/connection.php');

if(isset($_POST['email'], $_POST['password'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Busca o usuário pelo email
    $sql_code = "SELECT * FROM adms WHERE email = '$email' AND status = 1";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    if($sql_query->num_rows == 1) {
        $usuario = $sql_query->fetch_assoc();
        $hashedPassword = $usuario['psw'];

        // Verifica se a senha está correta
        if(password_verify($password, $hashedPassword)) {
            // Inicia a sessão se ainda não estiver iniciada
            if(!isset($_SESSION)) {
                session_start();
            }

            // Define as variáveis de sessão
            $_SESSION['id'] = $usuario['ID'];
            $_SESSION['nome'] = $usuario['name'];

            header("Location: ../system.php");
            exit;
        } else {
            //echo "Senha incorreta";
            header("Location: ../index.php");
        }
    } else {
        //echo "Usuário não encontrado";
        header("Location: ../index.php");
    }
} else {
    //echo "Preencha todos os campos";
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Screen</title>
    <style>
    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #1d3969;
        color: white;
        font-family: Arial, sans-serif;
    }

    .loader {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body>
    <div class="loader"></div>
</body>

</html>