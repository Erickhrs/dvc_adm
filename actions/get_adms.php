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