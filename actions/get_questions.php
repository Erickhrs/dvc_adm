<?php
include("../includes/connection.php");
include("../includes/protect.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT ID, question, adms_id, created_at, status, answer FROM questions";
$result = $mysqli->query($sql);
$users = array();

function getAdmName($mysqli, $id){
    $sql = "SELECT name FROM adms WHERE ID = $id";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows>0){
        $final = $result->fetch_assoc();
        return $final['name'];
    }
    else {
        return 'desconhecido';
    }
}

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        if ($row['answer'] == 1) {
            $row['answer'] = "Verdadeiro";
        } elseif ($row['answer'] == 0) {
            $row['answer'] = "Falso";
        } 
        $row['adms_id'] = getAdmName($mysqli,$row['adms_id']);
        $row['status'] = ($row['status'] == 1) ? "ativo" : "desativo";
        $users[] = $row;
    }
}
 else {
}
header('Content-Type: application/json');
echo json_encode($users);
?>