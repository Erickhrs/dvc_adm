<?php
// Inclui a conexão com o banco de dados e outras dependências
include('./includes/connection.php');
include('./includes/protect.php');

// Verifica se o e-mail foi passado pela URL
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Verifica se a mensagem foi enviada via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
        $message = $_POST['message'];

        // Defina o cabeçalho do e-mail
        $to = $email;
        $subject = 'Assunto do Email';
        $headers = 'From: seuemail@exemplo.com' . "\r\n" .
                   'Reply-To: seuemail@exemplo.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        // Tenta enviar o e-mail
        if (mail($to, $subject, $message, $headers)) {
            $alert = [
                'icon' => 'success',
                'title' => 'Sucesso!',
                'text' => 'O e-mail foi enviado com sucesso.',
            ];
        } else {
            $alert = [
                'icon' => 'error',
                'title' => 'Erro!',
                'text' => 'Falha ao enviar o e-mail.',
            ];
        }
    }
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Nenhum e-mail foi fornecido na URL.',
        }).then(function() {
            window.location = 'index.php'; // Redireciona para a página inicial
        });
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar E-mail</title>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Boxicons para ícones -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Estilo customizado -->
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    textarea {
        width: 100%;
        height: 150px;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: none;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button i {
        margin-right: 5px;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Enviar E-mail</h2>
        <p>Enviando para: <strong><?php echo $email; ?></strong></p>
        <form method="POST">
            <textarea name="message" placeholder="Digite sua mensagem" required></textarea>
            <button type="submit"><i class='bx bx-envelope'></i> Enviar E-mail</button>
        </form>
    </div>

    <?php if (isset($alert)): ?>
    <script>
    Swal.fire({
        icon: '<?php echo $alert['icon']; ?>',
        title: '<?php echo $alert['title']; ?>',
        text: '<?php echo $alert['text']; ?>',
    }).then(function() {
        window.location = 'messages.php'; // Redireciona para a página inicial
    });
    </script>
    <?php endif; ?>
</body>

</html>