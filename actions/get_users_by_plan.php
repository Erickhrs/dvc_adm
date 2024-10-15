<?php
include('../includes/connection.php');
include('../includes/protect.php');

// Array para armazenar o resultado
$result = [];

// Consultas para contar os usuários por plano
$sql = "
    SELECT plan, COUNT(*) as count
    FROM users
    GROUP BY plan
";

// Executa a consulta
if ($query = $mysqli->query($sql)) {
    while ($row = $query->fetch_assoc()) {
        $result[] = [
            'plan' => (int)$row['plan'],
            'count' => (int)$row['count']
        ];
    }
    $query->close();
} else {
    echo "Erro na consulta: " . $mysqli->error;
}

// Fecha a conexão
$mysqli->close();

// Retorna o resultado como JSON
header('Content-Type: application/json');
echo json_encode($result);
?>