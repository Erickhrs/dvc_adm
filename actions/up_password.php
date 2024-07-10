<?php
include('../includes/connection.php');
include('../includes/currentUserinfos.php');
include("../includes/protect.php");

$current_password = $_POST['current-password'];
$new_password = $_POST['new-password'];
$confirm_password = $_POST['confirm-password'];

if ($new_password != $confirm_password) {
    echo json_encode(array('error' => 'As senhas não coincidem.'));
    exit();
} else {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE adms set psw = '$hashed_password' WHERE ID = $user_id";

    if ($mysqli->query($sql)) {
        newHistoricEvent($_SESSION['id'], "Atualizou sua senha.", date('Y-m-d H:i:s'), 'BAIXA');
        session_destroy();
        header("Location: ../index.php");
        exit();
    } else {
        header('Location: ../error.php');
    }
}?>
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