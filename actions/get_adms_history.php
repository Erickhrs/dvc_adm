<?php
include("../includes/connection.php");
include("../includes/protect.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT h.description, h.occurred_at, h.importance, a.picture, a.name
FROM adms_history h JOIN adms a ON h.adms_ID = a.ID ORDER BY h.occurred_at DESC";
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