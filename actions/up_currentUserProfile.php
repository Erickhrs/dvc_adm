<?php
include("../includes/connection.php");
include('../includes/currentUserInfos.php');
include("../includes/protect.php");

$name_up = htmlspecialchars($_POST['name']);
$email_up = htmlspecialchars($_POST['email']);
$UF_up = htmlspecialchars($_POST['UF']);
$status_up = $_POST['status'];
$roles_id_up = $_POST['roles_id'];

if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
    $picture_up = $_FILES["picture"];
    $allowed_types = ['image/jpeg', 'image/png'];
    $file_type = mime_content_type($picture_up["tmp_name"]);
    if (!in_array($file_type, $allowed_types)) {
        die("Tipo de arquivo não permitido.");
        header('Location: ../error.php');
    }


    $directory = "./uploads/";
    $ext = pathinfo(basename($picture_up["name"]), PATHINFO_EXTENSION);
    $new_filename = uniqid() . "." . $ext;
    $current_picture = "." . $picture;
    $path = $directory . $new_filename;
    $destiny = "../uploads/" . $new_filename;

    if (file_exists($current_picture)) {
        if (unlink($current_picture)) {
        }
    }
    if (!move_uploaded_file($picture_up["tmp_name"], $destiny)) {
        die("Falha ao mover o arquivo.");
    }
} else{
    $path = $picture;

}


$sql = "UPDATE adms set name = ?, email = ?, UF = ?, picture = ?, status = ?, roles_id = ? WHERE id = ?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ssssiii", $name_up, $email_up, $UF_up, $path, $status_up, $roles_id_up, $user_id);
    $stmt->execute();
    $stmt->close();
    session_destroy();
    header("Location: ../index.php");
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