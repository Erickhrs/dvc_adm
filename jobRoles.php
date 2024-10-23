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
                    <h1>Novo Atributo</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a >Painel</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" >Home</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="questionType" style="background: none;">
                    <a href="./disciplines.php" id=""><i class='bx bx-coin'></i>Disciplinas</a>
                    <a href="./subjects.php" id=""><i class='bx bx-coin'></i>Assunto</a>
                    <a href="./bancas.php" id=""><i class='bx bx-coin'></i>Banca</a>
                    <a href="./jobRoles.php" id="" class="userType-active"><i class='bx bx-coin'></i>Cargo</a>
                    <a href="./courses.php" id=""><i class='bx bx-coin'></i>Formação</a>
                    <a href="./jobFunctions.php" id=""><i class='bx bx-coin'></i>Atuação</a>
                </div>
            </div>
            <div class="atrContainers">
                <div class="order"
                    style="    border-radius: 20px;background: var(--light);padding: 24px;overflow-x: auto;text-align: center;height: 50vh;overflow-y: auto;">
                    <div class="head">
                        <h3>Lista de Cargos</h3>
                    </div>
                    <table>
                        <?php
                        $displayType = 'list';
                        include_once('./actions/get_job_roles.php');
                        ?>
                    </table>
                </div>
                <div class="order"
                    style="    border-radius: 20px;background: var(--light);padding: 24px;overflow-x: auto;    width: 55%;text-align: center;    display: flex;flex-direction: column;gap: 18px;">
                    <div class="head">
                        <h3>Adicionar novo cargo</h3>
                        <span style="font-size: 11px;">Escreva o nome do cargo</span>
                    </div>
                    <form action="./actions/in_job_role.php" method="post">
                        <input type="text" name="newJob_role" id="" required>
                        <button type="submit"
                            style="    border: none;background-color: greenyellow;height: 30px;width: 30px;border-radius: 25px;cursor: pointer;"><i
                                class='bx bx-check'></i></button>
                    </form>
                    <div class="head">
                        <h3>Excluir Cargo</h3>
                        <span style="font-size: 11px;">Escreva o texto de validação e informe o ID e o nome</span>
                    </div>
                    <form action="./actions/deletingJob_role.php" method="post">
                        <input type="text" name="validation" id="" value="" placeholder="ESCREVA: eu quero excluir o #"
                            required>
                        <input type="text" name="atr_ID" id="" value="" placeholder="0" required>
                        <input type="text" name="atr_name" id="" value="" placeholder="escreva o nome do cargo"
                            required>
                        <button type="submit"
                            style="    border: none;background-color: red;height: 30px;width: 30px;border-radius: 25px;cursor: pointer;color:white;"><i
                                class='bx bx-x'></i></button>
                    </form>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src=" https://cdn.tiny.cloud/1/qk0ibpi1dj92lq7s1xyzxsuyvucx13dpmizy96s218ufe66x/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="./scripts/richtextarea.js"></script>
    <script src="./scripts/system.js"></script>
    <script type="module" src="./scripts/spa.js"></script>
</body>

</html>