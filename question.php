<?php
include('./includes/connection.php');
include('./includes/protect.php');
include('./includes/currentUserInfos.php');
$displayType = 'option';
$id = $_GET['id'];

function searchName($mysqli, $name, $chart, $id) {
    // Verifica se o ID contém um hífen ("-")
    if (strpos($id, '-') !== false) {
        // Separa os IDs em um array
        $ids = explode('-', $id);
        $names = [];

        // Busca o nome para cada ID separado
        foreach ($ids as $single_id) {
            $sql = "SELECT $name FROM $chart WHERE ID = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $single_id); // 'i' para integer
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $final = $result->fetch_assoc();
                $names[] = $final[$name]; // Adiciona o nome ao array
            } else {
                $names[] = 'ERRO'; // Adiciona 'ERRO' se o nome não for encontrado
            }
        }

        // Junta os nomes novamente com "-"
        return implode('-', $names);
    } else {
        // Caso o ID não tenha hífen, busca o nome normalmente
        $sql = "SELECT $name FROM $chart WHERE ID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id); // 'i' para integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $final = $result->fetch_assoc();
            return $final[$name];
        } else {
            return 'ERRO';
        }
    }
}


// Preparar e executar a primeira consulta
$stmt = $mysqli->prepare("SELECT question, adms_ID, question_type, status, year, level, grade_level, created_at, subject, banca, job_function, job_role, course, discipline, related_contents, `keys`, answer FROM questions WHERE ID = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($question, $adms_ID, $question_type, $status, $year, $level, $grade_level, $created_at, $subject, $banca, $job_function, $job_role, $course, $discipline, $related_contents, $keys, $answer);

if (!$stmt->fetch()) {
    echo 'Erro ao buscar a pergunta.';
    $stmt->close();
    $mysqli->close();
    exit();
}
$stmt->close();

$alternatives = array("A" => array(), "B" => array(), "C" => array(), "D" => array(), "E" => array());
$sql = "SELECT alternative, answer, correct FROM answers WHERE questions_ID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $alternative = $row["alternative"];
        if (array_key_exists($alternative, $alternatives)) {
            $alternatives[$alternative][] = array(
                "answer" => $row["answer"],
                "correct" => $row["correct"]
            );
        }
    }
}

$stmt->close();
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
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">

    <title>DVC - ADMIN</title>

    <style>
    label {
        color: var(--logo-blue);
        font-size: 20px;
    }

    .order {
        display: flex;
        flex-direction: column;
    }

    #answers_container {
        display: flex;
        flex-wrap: inherit;
        gap: 20px;
    }

    #atrs {
        margin-top: 20px;
        margin-left: 20px;
        margin-bottom: -8px;
    }

    .span_keys {
        background-color: #e7be87b0;
        padding: 5px;
        border-radius: 10px;
        color: #f98f01b0;
    }

    .span_about {
        background-color: #99dcc7b0;
        padding: 5px;
        border-radius: 10px;
        color: #01739fab;
    }

    .span_filter {
        background-color: #8bc34a73;
        padding: 5px;
        border-radius: 10px;
        color: #1a7e05d1;
    }
    </style>
</head>

<body>
    <section id="sidebar">
        <a class="brand"><img src="./assets/logo.png" alt=" logo"
                style="width: 137px; margin-left: 17px; margin-right: 15px"></a>
        <ul class="side-menu top">
            <li><a href="./system.php#dashboard"><i class='bx bxs-dashboard'></i><span class="text">Painel</span></a>
            </li>
            <li class="active"><a href="./system.php#questionManager"><i class='bx bxs-layer'></i><span
                        class="text">Gerenciador de Questões</span></a></li>
            <li><a href="./system.php#statistics"><i class='bx bx-stats'></i><span class="text">Estatísticas</span></a>
            </li>
            <li><a href="./system.php#messages"><i class='bx bxs-message-dots'></i><span
                        class="text">Mensagens</span></a></li>
            <li><a href="./system.php#users"><i class='bx bxs-group'></i><span class="text">Usuários</span></a></li>
            <li><a href="./system.php#history"><i class='bx bx-history'></i><span class="text">Histórico</span></a></li>
        </ul>
        <ul class="side-menu">
            <li><a href="#settings"><i class='bx bxs-cog'></i><span class="text">Configurações</span></a></li>
            <li><a href="./logout.php" class="logout"><i class='bx bx-exit'></i><span class="text">Sair</span></a></li>
        </ul>
    </section>
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a class="nav-link">Categorias</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a class="notification"><i class='bx bxs-bell'></i><span class="num">8</span></a>
            <a href="./profile.php" class="profile"><img src=<?php echo "$picture"?>></a>
        </nav>
        <main id="root">
            <div class="head-title">
                <div class="left">
                    <h1><?php echo '#' .  $id ?></h1>
                    <form action="edit_question.php" method="GET">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="type" value="<?php echo $question_type; ?>">
                        <button type="submit" class="question_option"><i class='bx bx-edit-alt'></i> editar</button>
                    </form>
                    <ul class="breadcrumb">
                        <li><a>Gerenciador Questões</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a>Painel</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active">Questões</a></li>
                    </ul>
                </div>
            </div>
            <div id="atrs">
                <?php if(!empty($keys)){echo "<span class='span_keys'>".$keys."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php if(!empty($year)){echo "<span class='span_about'>".$year."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php if(!empty($banca)){echo "<span class='span_about'>".searchName($mysqli, 'banca', 'bancas', $banca)."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php if(!empty($level)){echo "<span class='span_about'>".$level."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php 
                    if (!empty($question_type)) {
                        echo '<span class="span_about">';
                        if ($question_type == 'mult') {  
                            echo 'multipla escolha';
                        } else {
                            echo 'Verdadeiro ou Falso';
                        }
                        echo '</span>';
                    } else {
                        echo '<span class="span_keys">vazio</span>';
                    }
                ?>
                <?php if(!empty($subject)){echo "<span class='span_filter'>".searchName($mysqli, 'subject', 'subjects', $subject)."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php if(!empty($job_role)){echo "<span class='span_filter'>".searchName($mysqli, 'job_role', 'job_roles', $job_role)."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php if(!empty($discipline)){echo "<span class='span_filter'>".searchName($mysqli, 'discipline', 'disciplines', $discipline)."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php if(!empty($course)){echo "<span class='span_filter'>".searchName($mysqli, 'course', 'courses', $course)."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
                <?php if(!empty($job_function)){echo "<span class='span_filter'>".searchName($mysqli, 'job_function', 'job_functions', $job_function)."</span>";}else{echo "<span class='span_keys'>vazio</span>";}?>
            </div>
            <div class="table-data">
                <div class="order"
                    style="<?php if($question_type=='tf' && $answer==1){ echo 'border-bottom: 5px solid #afe3af';} if($question_type=='tf' && $answer==0){echo 'border-bottom: 5px solid #ff9c9c';}?>">
                    <label for="question"><i class='bx bx-note'></i> Questão</label>
                    <span><?php if ($question) { echo $question; } else { echo 'não encontrado'; } ?></span>
                </div>
            </div>
            <div id="answers_container" style="<?php if($question_type=='tf'){ echo 'display:none!important';}?>">
                <div class="table-data">
                    <div class="order"
                        style="<?php foreach ($alternatives["A"] as $info) { if ($info['correct']==1){echo 'background-color: #b5e0b5;';}} ?>">
                        <label for="OA">Alternativa A</label>
                        <span><?php foreach ($alternatives["A"] as $info) { echo $info["answer"] . "\n"; } ?></span>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order"
                        style="<?php foreach ($alternatives["B"] as $info) { if ($info['correct']==1){echo 'background-color: #b5e0b5;';}} ?>">
                        <label for="OB">Alternativa B</label>
                        <span><?php foreach ($alternatives["B"] as $info) { echo $info["answer"] . "\n"; } ?></span>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order"
                        style="<?php foreach ($alternatives["C"] as $info) { if ($info['correct']==1){echo 'background-color: #b5e0b5;';}} ?>">
                        <label for="OC">Alternativa C</label>
                        <span><?php foreach ($alternatives["C"] as $info) { echo $info["answer"] . "\n"; } ?></span>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order"
                        style="<?php foreach ($alternatives["D"] as $info) { if ($info['correct']==1){echo 'background-color: #b5e0b5;';}} ?>">
                        <label for="OD">Alternativa D</label>
                        <span><?php foreach ($alternatives["D"] as $info) { echo $info["answer"] . "\n"; } ?></span>
                    </div>
                </div>
                <?php
                foreach ($alternatives["E"] as $info) {
                    if (!empty($info['answer'])) {
                        echo ' <div class="table-data">
                            <div class="order" style="';
                            foreach ($alternatives["E"] as $info) {
                                if ($info["correct"] == 1) {
                                    echo 'background-color: #b5e0b5;';
                                }
                            }
                        echo '">
                                <label for="OE">Alternativa E</label>
                                <span>';
                                foreach ($alternatives["E"] as $info) {
                                    echo $info["answer"] . "\n";
                                }
                        echo '</span>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
            <div id="answers_container">
                <div class="table-data">
                    <div class="order">
                        <label for="related_content"><i class='bx bx-paperclip'></i> Relacionados</label>
                        <span><?php echo $related_contents; ?></span>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <script src="https://cdn.tiny.cloud/1/qk0ibpi1dj92lq7s1xyzxsuyvucx13dpmizy96s218ufe66x/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="./scripts/richtextarea.js"></script>
    <script src="./scripts/system.js"></script>
    <script type="module" src="./scripts/spa.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>
</body>

</html>