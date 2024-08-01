<?php
include("../includes/connection.php");
include("../includes/protect.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT ID, question,  from questions";
$result = $mysqli->query($sql);
$users = array();

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $row['status'] = ($row['status'] == 1) ? "ativo" : "desativo";
        $users[] = $row;
    }
}
 else {
}
header('Content-Type: application/json');
echo json_encode($users);
?>