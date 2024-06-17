<?php
include('connection.php');
include('protect.php');

//profile
$user_id = $_SESSION['id'];
$sql = "SELECT picture, name, email, UF, since, status, roles_id FROM adms WHERE id = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($picture, $name, $email, $UF, $since, $status, $roles_id);
    $stmt->fetch();
    $stmt->close();
} else {
    header("location: ../error.php");
}
if (!$picture) {
    $picture = "./assets/people.png";
}

$status = ($status == 1) ? "ativo" : "desativo";
$roles_id = ($roles_id == 1) ? "ADM" : "MOD";



?>