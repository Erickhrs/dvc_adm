<?php
include('./includes/connection.php');
include('./includes/protect.php');

$id =  $_GET['id'];

$stmt = $mysqli->prepare("SELECT question, adms_ID, question_type, status, year, level, grade_level, created_at, subject, banca, job_function, job_role, course, discipline, related_contents, `keys` FROM questions WHERE ID = ?");
$stmt->bind_param("i", $id);

$stmt->execute();


$stmt->bind_result($question, $adms_ID, $question_type, $status, $year, $level, $grade_level, $created_at, $subject, $banca, $job_function, $job_role, $course, $discipline, $related_contents, $keys);


if ($stmt->fetch()) {
  //  echo "Question: " . $question . "<br>";
} else {
   // echo "No record found.";
}
?>
<?php
include('./includes/connection.php');
include('./includes/protect.php');
include('./includes/currentUserInfos.php');
$displayType = 'option';
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
</head>

<body>

    <section id="sidebar">
        <a href="#" class="brand">
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
            <li class="active">
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
            <div class="head-title">
                <div class="left">
                    <h1><?php echo "#".$id ?></h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Painel</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
            <form action="./actions/in_question.php" method="post" style="margin-top: 30px;">
                <label for="question">Pergunta</label>
                <textarea class="question" name="question"
                    placeholder="Escreva a questão aqui..."><?php echo "$question" ?></textarea><br>
                <label for="">alternativas</label>
                <textarea class="question_option" name="oa"
                    placeholder="Escreva a alternativa A aqui..."></textarea><br>
                <textarea class="question_option" name="ob"
                    placeholder="Escreva a alternativa B aqui..."></textarea><br>
                <textarea class="question_option" name="oc"
                    placeholder="Escreva a alternativa C aqui..."></textarea><br>
                <textarea class="question_option" name="od"
                    placeholder="Escreva a alternativa D aqui..."></textarea><br>
                <textarea class="question_option" name="oe"
                    placeholder="Escreva a alternativa E aqui..."></textarea><br>
                <label for="related_contents">Conteúdos Relacionados</label>
                <textarea class="related_contents" name="related_contents" rows="4" cols="50"
                    placeholder='Liste suas referências ou Conteúdos Relacionados...'><?php echo "$related_contents"; ?></textarea><br>

                <div id="aboutQuestions" style="display: flex!important; flex-wrap: wrap!important;gap: 15px;">

                    <input type="text" name="nextId" id="nextId" disabled value="<?php echo $id;?>"
                        style="text-align: center;" required>

                    <input type="text" name="year" id="year" value="<?php echo $year;?>" style="text-align: center;"
                        required>

                    <input type="text" name="keys" placeholder="Palavras chaves" value="<?php echo $keys;?>">


                    <select name="subject" required>
                        <?php
                        include_once('./actions/get_subjects.php');
                        ?>
                    </select>
                    <select name="banca" required>
                        <?php
                        include_once('./actions/get_bancas.php');
                        ?>
                    </select>
                    <select name="job_role" required>
                        <?php
                        include_once('./actions/get_job_roles.php');
                        ?>
                    </select>


                    <select name="qType" id="" disabled required>
                        <option value="mult">Multipla Escolha</option>
                    </select>
                    <select name="level" required>
                        <option value="">Selecione a dificuldade</option>
                        <option value="facil">Fácil</option>
                        <option value="medio">Médio</option>
                        <option value="dificil">Difícil</option>
                    </select>
                    <label for="course" required>Formação</label>
                    <select name="course[]" id="courses" multiple>
                        <?php
                        $displayType = 'option';
                        include_once('./actions/get_courses.php');
                        ?>
                    </select>
                    <label for="course">Disciplina</label>
                    <select name="discipline[]" id="disciplines" multiple required>
                        <?php
                        $displayType = 'option';
                        include_once('./actions/get_disciplines.php');
                        ?>
                    </select>
                    <label for="course">Atuação</label>
                    <select name="job_function[]" id="job_funcions" multiple required>
                        <?php
                           $displayType = 'option';
                        include_once('./actions/get_jobFunctions.php');
                        ?>
                    </select>
                    <label for="course">Nível</label>
                    <select name="grade_level[]" id="grade_levels" multiple required>
                        <option value="">Selecione o nível</option>
                        <option value="fundamental">Fundamental</option>
                        <option value="médio">Médio</option>
                        <option value="superior">Superior</option>
                    </select>
                </div>
                <input type="submit" value="Cadastrar no banco de dados" id="cadbtn">
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
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>]
    <script>
    new MultiSelectTag('disciplines')
    new MultiSelectTag('grade_levels')
    new MultiSelectTag('job_funcions')
    new MultiSelectTag('courses')
    </script>
</body>

</html>