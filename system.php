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

    <title>DVC - ADMIN</title>
</head>

<body>

    <section id="sidebar">
        <a href="#" class="brand">
            <img src="./assets/logo.png" alt=" logo" style="width: 137px; margin-left: 17px;
			margin-right: 15px">
        </a>
        <ul class="side-menu top">
            <li class="active">
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
            <li>
                <a href="./system.php#messages">
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
                <a href="#settings">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Configurações</span>
                </a>
            </li>
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
            <a href="#" class="nav-link">Categorias</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="./profile.php" class="profile">
                <img src=<?php echo "$picture" ?>>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main id="root">
            <form action="./actions/in_question.php" method="post">
                <textarea id="question" name="question" rows="4" cols="50"
                    placeholder="Escreva a questão aqui..."></textarea><br>
                <label for="related">Conteudos Relacionados</label>
                <input type="text" name="related" style="width: 100%;">
                <div id="aboutQuestions" style="display: flex!important; flex-wrap: wrap!important;">
                    <input type="text" name="nextId" id="nextId" disabled placeholder="#13" value="#13"
                        style="text-align: center;">
                    <select id="ano" name="ano">
                        <option value="">Ano da questão</option>
                        <script>
                        for (let ano = 1980; ano <= 2030; ano++) {
                            document.write(`<option value="${ano}">${ano}</option>`);
                        }
                        </script>
                    </select>
                    <input type="text" name="keys" placeholder="Palavras chaves">

                    <select>
                        <?php
                        include_once('./actions/get_disciplines.php');
                        ?>
                    </select>
                    <select>
                        <?php
                        include_once('./actions/get_subjects.php');
                        ?>
                    </select>
                    <select>
                        <?php
                        include_once('./actions/get_bancas.php');
                        ?>
                    </select>
                    <select>
                        <?php
                        include_once('./actions/get_job_roles.php');
                        ?>
                    </select>
                    <select name="" id="">
                        <option value="">Selecione o nível</option>
                        <option value="">Fundamental</option>
                        <option value="">Médio</option>
                        <option value="">Superior</option>
                    </select>
                    <select>
                        <?php
                        include_once('./actions/get_courses.php');
                        ?>
                    </select>
                    <select name="" id="" disabled>
                        <option value="">Multipla Escolha</option>
                    </select>
                    <select name="" id="">
                        <option value="">Selecione a dificuldade</option>
                        <option value="">Fácil</option>
                        <option value="">Médio</option>
                        <option value="">Difícil</option>
                    </select>
                    <select>
                        <?php
                        include_once('./actions/get_functions.php');
                        ?>
                    </select>
                </div>
                <input type="submit" value="Enviar">
            </form>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="https://cdn.tiny.cloud/1/f8nx31hueqvfhjpkvu3nqmwof3kll4hmdsumuuklyf7ypoj0/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="./scripts/richtextarea.js"></script>
    <script src="./scripts/system.js"></script>
    <script type="module" src="./scripts/spa.js"></script>
</body>

</html>