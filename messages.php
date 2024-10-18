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
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./styles/system.css">
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/messages.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <section id="sidebar">
        <a class="brand">
            <img src="./assets/logo.png" alt=" logo" style="width: 137px; margin-left: 17px;
			margin-right: 15px">
        </a>
        <ul class="side-menu top">
            <li>
                <a href="./system.php#dashboard">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Painel</span>
                </a>
            </li>
            <li>
                <a href="./system.php#questionManager">
                    <i class='bx bxs-layer'></i>
                    <span class="text">Gerenciador de Questões</span>
                </a>
            </li>
            <li>
                <a href="./system.php#statistics">
                    <i class='bx bx-stats'></i>
                    <span class="text">Estatísticas</span>
                </a>
            </li>
            <li class="active">
                <a href="./messages.php">
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">Mensagens</span>
                </a>
            </li>
            <li>
                <a href="./system.php#users">
                    <i class='bx bxs-group'></i>
                    <span class="text">Usuários</span>
                </a>
            </li>
            <li>
                <a href="./system.php#history">
                    <i class='bx bx-history'></i>
                    <span class="text">Histórico</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">

            <li>
                <a href="./logout.php" class="logout">
                    <i class='bx bx-exit'></i>
                    <span class="text">Sair</span>
                </a>
            </li>
        </ul>
    </section>



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>




            <a href="./profile.php" class="profile">
                <img src=<?php echo "$picture" ?>>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main id="root">
            <div class="head-title">
                <div class="left">
                    <h1>Mensagens</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a>Mensagens</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active">Painel</a>
                        </li>
                    </ul>
                </div>
            </div>

            <?php
            include_once('./includes/get_messages.php');
            ?>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src=" https://cdn.tiny.cloud/1/qk0ibpi1dj92lq7s1xyzxsuyvucx13dpmizy96s218ufe66x/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="./scripts/richtextarea.js"></script>
    <script type="module" src="./scripts/spa.js"></script>
    <script>
    $(document).ready(function() {
        $('.confirm-view-button').on('click', function() {
            const questionID = $(this).data('id');
            const type = $(this).data('type');

            // Usa alert normal para confirmação
            const confirmAction = confirm("Você realmente deseja confirmar a visualização?");

            if (confirmAction) {
                // Se confirmado, envia a requisição AJAX para mudar o valor na tabela
                $.ajax({
                    url: './actions/update_view.php',
                    type: 'POST',
                    data: {
                        questionID: questionID,
                        type: type
                    },
                    success: function(response) {
                        // Se sucesso, exibe SweetAlert de sucesso
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Visualização confirmada com sucesso!',
                            icon: 'success',
                        }).then(() => {
                            // Recarrega a página para ver a alteração
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        // Se erro, exibe SweetAlert de erro
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao confirmar a visualização.',
                            icon: 'error',
                        });
                    }
                });
            }
        });
    });
    </script>

</body>

</html>