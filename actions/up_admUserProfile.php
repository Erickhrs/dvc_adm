<?php
include("../includes/connection.php");
include("../includes/protect.php");

$picture = $_POST['picture_adm'];
$adm_id = $_POST['adm_id'];
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
    $stmt->bind_param("ssssiii", $name_up, $email_up, $UF_up, $path, $status_up, $roles_id_up, $adm_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../system.php");
} else {
   header("Location: ../error.php");
}
$mysqli->close();