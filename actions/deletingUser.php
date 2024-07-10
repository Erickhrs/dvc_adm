<?php
include('../includes/connection.php');
include('../includes/protect.php');
$picture = $_POST['picture'];
$type = $_POST['userType'];
$id = $_POST['id_user'];
$email = $_POST['email_user'];
if ($type == 'user') {
    if (isset($id) && isset($email)) {
        $sql = "SELECT * from users where email = '$email' and id = $id";
        $sql_query = $mysqli->query($sql) or die("Falha na execução do código SQL: " . $mysqli->error);
        if ($sql_query->num_rows == 1) {
            $sql = "DELETE from users where email = '$email' and id = $id";
            $sql_query = $mysqli->query($sql) or die("Falha na execução do código SQL: " . $mysqli->error);
            if (file_exists($picture)) {
                if (unlink($picture)) {
                }
            }
            header('Location: ../system.php#users');
        } else {
            header('Location: ../erro.php');
        }
    } else {
        header('Location: ../erro.php');
    }
} else if ($type == 'adm') {
    if (isset($id) && isset($email)) {
        $sql = "SELECT * from adms where email = '$email' and id = $id";
        $sql_query = $mysqli->query($sql) or die("Falha na execução do código SQL: " . $mysqli->error);
        if ($sql_query->num_rows == 1) {
            $sql = "DELETE from adms where email = '$email' and id = $id";
            $sql_query = $mysqli->query($sql) or die("Falha na execução do código SQL: " . $mysqli->error);
            if (file_exists($picture)) {
                if (unlink($picture)) {
                }
            }
            header('Location: ../system.php#adms');
        }
    } else {
        header('Location: ../erro.php');
    }
} else {
    header('Location: ../erro.php');
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