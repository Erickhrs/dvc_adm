<?php
include("../includes/connection.php");
include("../includes/protect.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT ID, name, email, phone, CPF, CNPJ, address, district, city, UF, CEP, picture, birth, since, status from users";
$result = $mysqli->query($sql);
$users = array();

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $row['status'] = ($row['status'] == 1) ? "ativo" : "desativo";
        $users[] = $row;
    }
}
 else {
}
header('Content-Type: application/json');
echo json_encode($users);
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