<?php
include_once('../includes/connection.php');
include_once('../includes/protect.php');
include_once('../includes/history.php');

if (isset($_POST) && !empty($_POST) && $_POST['validation'] == 'eu quero excluir o #') {
    function isUtilized($mysqli, $coldb, $value)
    {
        $sql = "SELECT * FROM questions WHERE $coldb = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->store_result();
        $isUtilized = $stmt->num_rows > 0;
        $stmt->close();
        return $isUtilized;
    } 

    $ID = $_POST['atr_ID'];
    $name = $_POST['atr_name'];
    if (isUtilized($mysqli, 'discipline', $ID)){
        echo "<script>alert('ERRO: HÁ QUESTÕES VINCULADAS A ESSA DISCIPLINA...')</script>";
        header('Location: ../erro.php');
    }
    else {
        $sql = "DELETE FROM disciplines where ID = '$ID'";
        $sql_query = $mysqli->query($sql) or die("Falha na execução do código SQL: " . $mysqli->error);
        newHistoryEvent($_SESSION['id'], "Deletou uma disciplina (#". $ID . " - " . $name . ")", date('Y-m-d H:i:s'), 'ALTA');
        header('Location: ../disciplines.php');
    }
}
else{
    header('Location: ../disciplines.php');
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