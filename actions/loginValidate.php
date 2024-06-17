<?php
include('../includes/connection.php');

if(isset($_POST['email'], $_POST['password'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Busca o usuário pelo email
    $sql_code = "SELECT * FROM adms WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    if($sql_query->num_rows == 1) {
        $usuario = $sql_query->fetch_assoc();
        $hashedPassword = $usuario['psw'];

        // Verifica se a senha está correta
        if(password_verify($password, $hashedPassword)) {
            // Inicia a sessão se ainda não estiver iniciada
            if(!isset($_SESSION)) {
                session_start();
            }

            // Define as variáveis de sessão
            $_SESSION['id'] = $usuario['ID'];
            $_SESSION['nome'] = $usuario['name'];

            header("Location: ../system.php");
            exit;
        } else {
            //echo "Senha incorreta";
            header("Location: ../index.php");
        }
    } else {
        //echo "Usuário não encontrado";
        header("Location: ../index.php");
    }
} else {
    //echo "Preencha todos os campos";
    header("Location: ../index.php");
}
?>