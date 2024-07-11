<?php
include('../includes/connection.php');
include('../includes/protect.php');
include('../includes/history.php');
$name = $_POST['name'];
$email = $_POST['email'];
$UF = $_POST['uf'];
$status = $_POST['status'];
$role = $_POST['role'];
$since = date('Y-m-d');
$psw = password_hash($psw, PASSWORD_DEFAULT);


function isDuplicate($mysqli, $coldb, $value)
{
    $sql = "SELECT * FROM adms WHERE $coldb = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();
    $isDuplicate = $stmt->num_rows > 0;
    $stmt->close();
    return $isDuplicate;
}

if (isDuplicate($mysqli, 'email', $email)) {
    echo "
    <div class=\"container\">
                <div class=\"alert alert-danger\">
                    <h2>ERRO: O email informado já está registrado no banco de dados...</h2>.
                </div>
            </div>
    ";
} else {

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
        $path = $directory . $new_filename;
        $destiny = "../uploads/" . $new_filename;

        if (!move_uploaded_file($picture_up["tmp_name"], $destiny)) {
            die("Falha ao mover o arquivo.");
        }
        echo " <div class=\"container\">
        <div class=\"alert inDone\">
            <h2>Usuário cadastrado com sucesso!</h2>.<p><a class=\"link\" href=\"../system.php\">Okay</a></p>
        </div>
    </div>";

        $sql = "INSERT INTO adms (name, email, uf, picture,  since, status, psw, roles_id) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param(
            "ssssssss",
            $name,
            $email,
            $UF,
            $path,
            $since,
            $status,
            $psw,
            $role
        );

        $stmt->execute();

        $stmt->close();
        $mysqli->close();
        newHistoryEvent($_SESSION['id'], "Usuário " . $name . " cadastrado", date('Y-m-d H:i:s'), 'MÉDIA');
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .inDone {
            background-color: #adeaa9;
            color: #000000;
            border: 1px solid #49d623;
        }

        .alert a {
            color: #721c24;
            text-decoration: underline;
        }

        .alert a:hover {
            color: #721c24;
        }

        .link {
            text-decoration: none;
            color: #007bff;
        }

        .link:hover {
            text-decoration: underline;
        }

        p {
            margin-left: auto;
            margin-right: auto;
            width: fit-content;
        }

        h2 {
            margin-left: auto;
            margin-right: auto;
            width: fit-content;
        }
    </style>
</head>

<body>

</body>

</html>