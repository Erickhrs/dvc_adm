<?php
include('../includes/connection.php');
include('../includes/protect.php');

$query = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS total 
          FROM questions 
          GROUP BY month 
          ORDER BY month";

$result = $mysqli->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>