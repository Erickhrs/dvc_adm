<?php
// Conexão com o banco de dados
include('../includes/connection.php');
include('../includes/protect.php');

$query = "SELECT is_correct FROM users_answers";
$result = $mysqli->query($query);

$answers = [];

while ($row = $result->fetch_assoc()) {
    $answers[] = $row;
}

echo json_encode($answers);
?>