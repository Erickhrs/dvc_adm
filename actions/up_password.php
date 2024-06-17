<?php
include('../includes/connection.php');
include('../includes/currentUserinfos.php');
include("../includes/protect.php");

$current_password = $_POST['current-password'];
$new_password = $_POST['new-password'];
$confirm_password = $_POST['confirm-password'];

if ($new_password != $confirm_password) {
    echo json_encode(array('error' => 'As senhas não coincidem.'));
    exit();
} else {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE adms set psw = '$hashed_password' WHERE ID = $user_id";

    if ($mysqli->query($sql)) {
        session_destroy();
        header("Location: ../index.php");
        exit();
    } else {
        header('Location: ../error.php');
    }
}