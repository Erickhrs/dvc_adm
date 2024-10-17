<?php
include('./includes/connection.php');
include('./includes/protect.php');
include('./includes/currentUserInfos.php');

// Verifique se o ID da questão foi passado via GET
if (isset($_GET['id'])) {
    $question_id = $_GET['id']; // Certifique-se de que é um número inteiro

    // Consulta para obter os dados da questão
    $query = "SELECT * FROM questions WHERE ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $question = $result->fetch_assoc();
    } else {
        die("Questão não encontrada.");
    }
} else {
    die("ID da questão não fornecido.");
}

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
    <style>
    form {
        display: flex;
        justify-content: left;
        flex-direction: column;
        gap: 20px;
        margin-top: 35px;
    }

    button {
        border: none;
        background-color: lawngreen;
        color: #06580c;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
    }

    #answer {
        margin: 0px !important;
    }

    label {
        background-color: white;
        color: #157fc8;
        padding: 10px;
        width: fit-content;
        border-radius: 4px;
    }
    </style>

    <section id="sidebar">
        <a href="#" class="brand">
            <img src="./assets/logo.png" alt=" logo" style="width: 137px; margin-left: 17px; margin-right: 15px">
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
            <a href="#" class="nav-link">Categorias</a>


            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="./profile.php" class="profile">
                <img src=<?php echo "$picture" ?> alt="User Profile">
            </a>
        </nav>
        <!-- NAVBAR -->
        <!-- MAIN -->
        <main id="root">
            <div class="head-title">
                <div class="left">
                    <h1>Editar Questão
                        <?PHP
                        echo $_GET['id'];
                        ?>
                    </h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Gerenciador Questões</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Edição de Questão</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
            if ($_GET['type'] == 'tf') {
                ?>
            <form action="./actions/update_question.php" method="POST">
                <input type="hidden" name="question_id" value="<?php echo $_GET['id'];?>">
                <input type="hidden" name="type" value="<?php echo $_GET['type'];?>">

                <label for="question">Questão:</label>
                <textarea class="question" name="question"
                    rows="4"><?php echo htmlspecialchars($question['question']); ?></textarea>

                <label for="prof_comment">Comentário do Professor:</label>
                <textarea id="prof_comment" class="question" name="prof_comment"
                    rows="4"><?php echo htmlspecialchars($question['prof_comment']); ?></textarea>

                <label for="related_contents">Conteúdos Relacionados:</label>
                <textarea id="related_contents" class="question" name="related_contents"
                    rows="4"><?php echo htmlspecialchars($question['related_contents']); ?></textarea>

                <label for="answer">Resposta:</label>
                <select id="answer" name="answer">
                    <option value="1" <?php echo $question['answer'] == 1 ? 'selected' : ''; ?>>Verdadeiro</option>
                    <option value="0" <?php echo $question['answer'] == 0 ? 'selected' : ''; ?>>Falso</option>
                </select>

                <button type="submit">Salvar Alterações</button>
            </form>
            <?php
            } else if ($_GET['type'] == 'mult') {
                // Consulta para obter as alternativas da questão
                $query_answers = "SELECT * FROM answers WHERE questions_ID = ?";
                $stmt_answers = $mysqli->prepare($query_answers);
                $stmt_answers->bind_param("s", $question_id);
                $stmt_answers->execute();
                $result_answers = $stmt_answers->get_result();

                // Variáveis para armazenar as alternativas
                $options = [];
                $has_option_e = false;

                while ($answer = $result_answers->fetch_assoc()) {
                    $options[] = $answer;
                    if ($answer['alternative'] === 'E') {
                        $has_option_e = true;
                    }
                }

                ?>
            <form action="./actions/update_question.php" method="POST">
                <input type="hidden" name="question_id" value="<?php echo $_GET['id'];?>">
                <input type="hidden" name="type" value="<?php echo $_GET['type'];?>">

                <label for="question">Questão:</label>
                <textarea class="question" name="question"
                    rows="4"><?php echo htmlspecialchars($question['question']); ?></textarea>

                <label for="prof_comment">Comentário do Professor:</label>
                <textarea id="prof_comment" class="question" name="prof_comment"
                    rows="4"><?php echo htmlspecialchars($question['prof_comment']); ?></textarea>

                <label for="related_contents">Conteúdos Relacionados:</label>
                <textarea id="related_contents" class="question" name="related_contents"
                    rows="4"><?php echo htmlspecialchars($question['related_contents']); ?></textarea>

                <label>Alternativas (ABCDE):</label>
                <?php
                foreach ($options as $option) {
                    if (!$has_option_e && $option['alternative'] === 'E') {
                        continue; // Pular a alternativa E se não houver
                    }
                    ?>
                <textarea class="question" name="answers[]"
                    rows="2"><?php echo htmlspecialchars($option['answer']); ?></textarea>
                <?php
                }
                ?>

                <button type="submit">Salvar Alterações</button>
            </form>
            <?php
            }
            ?>
        </main>
        <!-- MAIN -->
    </section>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>
    <script src=" https://cdn.tiny.cloud/1/qk0ibpi1dj92lq7s1xyzxsuyvucx13dpmizy96s218ufe66x/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="./scripts/richtextarea.js"></script>
    <script src="./scripts/system.js"></script>
    <script src="./scripts/global.js"></script>
</body>

</html>