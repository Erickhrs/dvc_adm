<?php
include_once('../includes/connection.php');
include_once('../includes/protect.php');
include("../includes/history.php");

if (isset($_POST['newJob_role']) && !empty($_POST['newJob_role'])) {
    function isDuplicate($mysqli, $coldb, $value)
    {
        $sql = "SELECT * FROM job_roles WHERE $coldb = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->store_result();
        $isDuplicate = $stmt->num_rows > 0;
        $stmt->close();
        return $isDuplicate;
    }
    $new = $_POST['newJob_role'];
    if (isDuplicate($mysqli, 'job_role', $new)) {
        echo "<script>alert('ERRO: JA EXISTE ESSE ATRIBUTO')</script>";
        header('Location: ../jobRoles.php');
    } else{
    $sql = 'INSERT INTO job_roles (job_role) VALUES (?)';

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param(
        "s",
        $new
    );

    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    newHistoryEvent($_SESSION['id'], "Adicionou um novo cargo (". $new . ")", date('Y-m-d H:i:s'), 'BAIXA');
    header('Location: ../jobRoles.php');
    }
   
} else {
    echo "<script>alert('ERRO: CAMPO NÃO PODE ESTAR VAZIO')</script>";
    header('Location: ../jobRoles.php');
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