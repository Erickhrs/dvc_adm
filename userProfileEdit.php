<?php
include('./includes/connection.php');
include('./includes/protect.php');
include('./includes/currentUserInfos.php');

if (isset($_POST['name_user'])) {
    $name_user = $_POST['name_user'];
    $id_user = $_POST['id_user'];
    $email_user = $_POST['email_user'];
    $UF_user = $_POST['uf_user'];
    $since_user = $_POST['since_user'];
    $status_user = $_POST['status_user'];
    $picture_user = $_POST['picture_user'];
    $phone_user = $_POST['phone_user'];
    $cpf_user = $_POST['cpf_user'];
    $cnpj_user = $_POST['cnpj_user'];
    $address_user = $_POST['address_user'];
    $district_user = $_POST['district_user'];
    $city_user = $_POST['city_user'];
    $birth_user = $_POST['birth_user'];
    $cep_user = $_POST['cep_user'];
} else {
    header('Location: ./erro.php');
}
if ($cpf_user == "null") {
    $idUserCode = $cnpj_user;
} elseif ($cnpj_user == "null") {
    $idUserCode = $cpf_user;
}
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
        <a class="brand">
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
          
          
            
         
            <a href="" class="profile">
                <img src=<?php echo "$picture" ?>>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main id="root">
            <div class="head-title">
                <div class="left">
                    <h1>Perfil Adm</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a>Painel</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active">Usuários</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active">Edição</a>
                        </li>
                    </ul>
                </div>
            </div>
            <form class="userInfos_edit" method="post" action="./actions/up_userProfile.php"
                enctype="multipart/form-data">
                <li>
                    <div id="ProfileImages">
                        <img src="<?php echo $picture_user; ?>">
                    </div>
                    <div class=" text">
                        <p>
                            <i class='bx bx-user'></i>Nome: <br>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($name_user); ?>">
                        </p>
                        <p>
                            <i class='bx bx-envelope'></i>Email:<br>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($email_user); ?>">
                        </p>
                        <p>
                            <i class='bx bxs-phone'></i>Telefone:<br>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($phone_user); ?>">
                        </p>
                        <p>
                            <i class='bx bxs-id-card'></i>ID:<br>
                            <input type="text" disabled name="idUserCode"
                                value="<?php echo htmlspecialchars($idUserCode); ?>">
                        </p>
                        <p>
                            <i class='bx bx-map-pin'></i>Endereço:<br>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($address_user); ?>">
                        </p>
                        <p>
                            <i class='bx bx-map-pin'></i>Bairro:<br>
                            <input type="text" name="district" value="<?php echo htmlspecialchars($district_user); ?>">
                        </p>
                        <p>
                            <i class='bx bx-map-pin'></i>Cidade:<br>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($city_user); ?>">
                        </p>
                        <p>
                            <i class='bx bxs-map-alt'></i>UF:<br>
                            <input type="text" name="UF" value="<?php echo htmlspecialchars($UF_user); ?>">
                        </p>
                        <p>
                            <i class='bx bx-building-house'></i>CEP:<br>
                            <input type="text" name="cep" value="<?php echo htmlspecialchars($cep_user); ?>">
                        </p>
                        <p>
                            <i class='bx bxs-cake'></i>Nascimento:<br>
                            <input type="text" name="birth" value="<?php echo htmlspecialchars($birth_user); ?>">
                        </p>
                        <p>
                            <i class='bx bx-station'></i>Status:<br>
                            <select name="status">
                                <option value="1" <?php if ($status_user == 'ativo') echo 'selected'; ?>>Ativo
                                </option>
                                <option value="0" <?php if ($status_user == 'desativo') echo 'selected'; ?>>Inativo
                                </option>
                            </select>
                        </p>
                        <input name="user_id" value="<?php echo htmlspecialchars($id_user); ?>" type="hidden">
                        <button type="submit">CONCLUIR EDIÇÃO</button>
                    </div>
                </li>
            </form>

            </ </main>
            <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="./scripts/system.js"></script>
    <script type="module" src="./scripts/spa.js"></script>
</body>

</html>