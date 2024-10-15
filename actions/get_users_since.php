<?php
header('Content-Type: application/json');

include('../includes/connection.php');
include('../includes/protect.php');

$query = "SELECT DATE_FORMAT(since, '%Y-%m') as month, COUNT(*) as total FROM users GROUP BY month";
$result = $mysqli->query($query);

$users_per_month = [];
while ($row = $result->fetch_assoc()) {
    $users_per_month[] = $row;
}

echo json_encode($users_per_month);
?>