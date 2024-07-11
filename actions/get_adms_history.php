<?php
include("../includes/connection.php");
include("../includes/protect.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT adms_ID, description, occurred_at, importance FROM adms_history ORDER BY occurred_at DESC";
$result = $mysqli->query($sql);

$history = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
} else {
    header('Location: ../erro.php');
}
$mysqli->close();
header('Content-Type: application/json');
echo json_encode($history);
?>