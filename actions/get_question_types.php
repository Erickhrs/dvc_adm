<?php
header('Content-Type: application/json');
include('../includes/connection.php');
include('../includes/protect.php');

$query = "SELECT question_type, COUNT(*) as count FROM questions WHERE question_type IN ('mult', 'tf') GROUP BY question_type";
$result = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['question_type']] = (int)$row['count'];
}

echo json_encode($data);
?>