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
$mysqli->close();?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Screen</title>
    <style>
    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #1d3969;
        color: white;
        font-family: Arial, sans-serif;
    }

    .loader {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body>
    <div class="loader"></div>
</body>

</html>