<?php
//arquvios básicos para conexão e proteção
include("../includes/connection.php");
include("../includes/protect.php");

//verificando se a conexão está funcionando.
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// escreve a receita que quer seguir, neste caso, uma consulta SQL para pegar informações dos administradores.
$sql = "SELECT ID, name, email, UF, picture, since, status, roles_id FROM adms";
// entrega essa receita para o garçom (o banco de dados) para que ele busque as informações.
$result = $mysqli->query($sql);

//onde vai guardar as informações dos administradores que o garçom vai trazer.
$users = array();

// verifica se ele trouxe alguma coisa.
if ($result->num_rows > 0) {
    // Se ele trouxe algo, você vai colocando cada item no recipiente, como colocar cada ingrediente na panela.
    while($row = $result->fetch_assoc()) {
        $row['status'] = ($row['status'] == 1) ? "ativo" : "desativo";
        $row['roles_id'] = ($row['roles_id'] == 1) ? "ADM" : "MOD";
        $users[] = $row;
    }
} else {
    header('Location: ../erro.php');
}
$mysqli->close();

// Antes de servir o jantar, você informa que tipo de comida está servindo, neste caso, um prato JSON.
header('Content-Type: application/json');

// Finalmente, você serve o jantar (os dados dos usuários) no formato JSON.
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