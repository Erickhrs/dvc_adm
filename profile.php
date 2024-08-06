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
        <a  class="brand">
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
            <a  class="nav-link">Categorias</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a  class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="" class="profile">
                <img src=<?php echo "$picture" ?>>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main id="root">
            <div class="head-title">
                <div class="left">
                    <h1>Perfil</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a >Painel</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="./profile.php">Perfil</a>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="userInfos">
                <li>
                    <div class="editPersonalInfos">
                        <a href="./ChangePassword.php"><i class='bx bxs-key' title="Atualizar senha"></i></a>
                        <a href="./profileEdit.php"> <i class='bx bx-edit' title="Editar Informações do perfil"></i></a>
                    </div>
                    <img src=<?php echo "$picture" ?>>
                    <div class="text">
                        <p>
                            <i class='bx bx-user'></i>Nome: <br><span><?php echo "$name" ?></span>
                        </p>
                        <p>
                            <i class='bx bx-envelope'></i>Email:<br><span><?php echo "$email" ?></span>
                        </p>
                        <p>
                            <i class='bx bxs-map-alt'></i>UF:<br><span><?php echo "$UF" ?></span>
                        </p>
                        <P>
                            <i class='bx bxs-calendar'></i>Desde:<br><span><?php echo "$since" ?></span>
                        </P>
                        <p>
                            <i class='bx bx-station'></i>Status:<br>
                            <span class="<?php echo htmlspecialchars($status); ?>_status">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </p>
                        <P>
                            <i class='bx bx-briefcase'></i>Cargo:<br>
                            <span class="<?php echo "$roles_id" ?>_cargo"><?php echo "$roles_id" ?>
                            </span>
                        </P>
                    </div>
                </li>
            </ul>
            <ul class="box-info">
                <li>
                    <i class='bx bxs-layer'></i>
                    <span class="text">
                        <h3>0</h3>
                        <p>Questões</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3>0</h3>
                        <p>Usuários Assinantes</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">
                        <h3>0</h3>
                        <p>Mensagens</p>
                    </span>
                </li>
            </ul>
            </ </main>
            <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="./scripts/system.js"></script>
    <script type="module" src="./scripts/spa.js"></script>
</body>

</html>