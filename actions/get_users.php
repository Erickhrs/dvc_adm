<?php
include("../includes/connection.php");
include("../includes/protect.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT ID, name, email, phone, CPF, CNPJ, address, district, city, UF, picture, birth, since, status from users";
$result = $mysqli->query($sql);
$users = array();

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
 else {
}
header('Content-Type: application/json');
echo json_encode($users);
?>