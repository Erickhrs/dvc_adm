<?php
include('../includes/connection.php');
include('../includes/protect.php');

// Array para armazenar o resultado
$result = [];

// Consulta para contar interações (comments e feedbacks) por mês
$sql = "
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') AS month, 
        COUNT(*) AS count 
    FROM (
        SELECT created_at FROM comments
        UNION ALL
        SELECT created_at FROM feedbacks
    ) AS interactions
    GROUP BY month
    ORDER BY month
";

// Executa a consulta
if ($query = $mysqli->query($sql)) {
    while ($row = $query->fetch_assoc()) {
        $result[] = [
            'month' => $row['month'],
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