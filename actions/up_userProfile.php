<?php
include("../includes/connection.php");
include("../includes/protect.php");

$user_id = $_POST['user_id'];
$name_up = $_POST['name'];
$email_up = $_POST['email'];
$UF_up = $_POST['UF'];
$status_up = $_POST['status'];
$phone_up = $_POST['phone'];
$address_up = $_POST['address'];
$district_up = $_POST['district'];
$city_up = $_POST['city'];
$birth_up = $_POST['birth'];
$cep_up = $_POST['cep'];

$sql = "UPDATE users set name = ?, email = ?, UF = ?, phone = ?, address = ?, district = ?, city = ?, birth = ?, CEP = ?, status = ? WHERE ID = ?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ssssssssiii", $name_up, $email_up, $UF_up, $phone_up, $address_up, $district_up, $city_up, $birth_up, $cep_up, $status_up, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../system.php");
} else {
   header("Location: ../error.php");
}
$mysqli->close();