<?php
$picture = "." . $_POST['picture_user'];
$name = $_POST['name_user'];
if ($_POST['userType'] == 'user') {
} else {
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuário</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #1d3969;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 400px;
        width: 100%;
    }

    h1 {
        color: red;
        margin-bottom: 20px;
    }

    .user-info {
        margin-bottom: 20px;
    }

    .user-info img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .buttons button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .delete-button {
        background-color: red;
        color: white;
    }

    .deactivate-button {
        background-color: #ccc;
    }

    .delete-button:hover {
        background-color: darkred;
    }

    .deactivate-button:hover {
        background-color: #bbb;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tem certeza que deseja excluir este usuário?</h1>
        <div class="user-info">
            <img src="<?php echo $picture?>" alt="Foto do Usuário">
            <p>Nome: <?php echo $name?></p>
        </div>
        <div class="buttons">
            <button class="delete-button">Sim, tenho certeza</button>
            <button class="deactivate-button">Não, quero apenas desativar o perfil desta pessoa</button>
        </div>
    </div>
</body>

</html>