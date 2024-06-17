<?php
include('./includes/connection.php');
include('./includes/protect.php');
include('./includes/currentUserInfos.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudar Senha</title>
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/changePassword.css">
</head>

<body>
    <div class="container">
        <h2>Alterar Senha</h2>
        <img src="./assets/logo.png" alt="logo" id="logo">
        <form id="change-password-form" action="./actions/up_password.php" method="post">
            <div class="form-group">
                <label for="current-password">Senha Atual:</label>
                <input type="password" id="current-password" name="current-password" required>
            </div>
            <div class="form-group">
                <label for="new-password">Nova Senha:</label>
                <input type="password" id="new-password" name="new-password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirme a Nova Senha:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit">Mudar Senha</button>
        </form>
        <div id="message"></div>
    </div>
    <!--  <script src="./scripts/changePassword.js">
    </script>
-->

</body>

</html>