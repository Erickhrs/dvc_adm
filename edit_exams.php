<?php
// Incluindo conexão, proteção e funções
include('./includes/connection.php');
include('./includes/protect.php');
include('./includes/functions.php');

// Verificando se o ID do exame está na URL
if (isset($_GET['id'])) {
    $exam_id = $_GET['id'];

    // Buscando os dados do exame a partir do ID
    $stmt = $mysqli->prepare("SELECT title, description, questions FROM exams WHERE ID = ?");
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $result_exam = $stmt->get_result();

    if ($result_exam->num_rows > 0) {
        $exam_data = $result_exam->fetch_assoc();
        $title = $exam_data['title'];
        $description = $exam_data['description'];
        $questions = explode('/', $exam_data['questions']); // Separando os IDs das questões
    } else {
        echo "<p class='error-msg'>Exame não encontrado.</p>";
        exit;
    }

    // Fechando a declaração
    $stmt->close();
} else {
    echo "<p class='error-msg'>ID do exame não especificado.</p>";
    exit;
}

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pegando os dados do formulário
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Verificando se as questões foram selecionadas
    if (!empty($_POST['questions'])) {
        // Pegando os IDs das questões selecionadas
        $selected_questions = implode('/', $_POST['questions']);
        
        // Verificando se os campos título e descrição não estão vazios
        if (!empty($title) && !empty($description)) {
            // Preparando a consulta para atualizar os dados
            $stmt = $mysqli->prepare("UPDATE exams SET title = ?, description = ?, questions = ? WHERE ID = ?");
            $stmt->bind_param("sssi", $title, $description, $selected_questions, $exam_id);

            // Executando a consulta
            if ($stmt->execute()) {
                header('Location: system.php?redirect=questionManager');
            } else {
                echo "<p class='error-msg'>Erro ao editar simulado: " . $stmt->error . "</p>";
            }

            // Fechando a declaração
            $stmt->close();
        } else {
            echo "<p class='error-msg'>Por favor, preencha todos os campos.</p>";
        }
    } else {
        echo "<p class='error-msg'>Por favor, selecione ao menos uma questão.</p>";
    }
}

// Buscando todas as questões para exibição no formulário
$result = $mysqli->query("SELECT ID, question, question_type, year, level, grade_level, subject, banca, job_function, job_role, course, discipline FROM questions");

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Simulado</title>
    <style>
    :root {
        --main-color: #648e4a;
        --logo-blue: #1d3969;
        --logo-green: #007700;
        --light-green: #6aac41;
        --green-todbg: #b3e295;
        --gold: #FFD700;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        color: var(--logo-blue);
    }

    h1 {
        background-color: var(--main-color);
        color: white;
        padding: 15px;
        text-align: center;
    }

    form {
        margin: 20px auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        margin-top: 10px;
    }

    input[type="text"],
    textarea,
    input[type="search"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid var(--main-color);
        border-radius: 4px;
    }

    input[type="text"]:focus,
    textarea:focus,
    input[type="search"]:focus {
        border-color: var(--light-green);
        outline: none;
    }

    button {
        background-color: var(--main-color);
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-bottom: 20px;
    }

    button:hover {
        background-color: var(--light-green);
    }

    .success-msg {
        color: var(--main-color);
        font-weight: bold;
        text-align: center;
    }

    .error-msg {
        color: red;
        font-weight: bold;
        text-align: center;
    }

    /* Estilos para a tabela */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: var(--logo-blue);
        color: white;
    }

    td {
        background-color: white;
    }

    tr:nth-child(even) {
        background-color: var(--green-todbg);
    }

    input[type="checkbox"] {
        transform: scale(1.2);
    }

    /* Estilos para o campo de pesquisa */
    #searchInput {
        padding: 10px;
        width: 98%;
        margin-top: 10px;
        margin-bottom: 20px;
        border: 2px solid var(--main-color);
        border-radius: 4px;
    }

    #searchInput:focus {
        border-color: var(--light-green);
        outline: none;
    }
    </style>
    <script>
    // Função para filtrar a tabela com base no valor do input de busca
    function filterTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toLowerCase();
        table = document.getElementById("questionsTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) { // Começar da segunda linha (i=1) para ignorar o cabeçalho
            tr[i].style.display = "none"; // Ocultar todas as linhas inicialmente

            // Loop em cada célula da linha atual
            for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = ""; // Exibir a linha se houver correspondência
                        break;
                    }
                }
            }
        }
    }
    </script>
</head>

<body>
    <h1>Criar Simulado</h1>
    <form method="POST" action="">
        <button type="submit">Salvar alterações</button> <br>
        <label for="title">Título do Simulado:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>

        <label for="description">Descrição do Simulado:</label><br>
        <textarea id="description" name="description"
            required><?php echo htmlspecialchars($description); ?></textarea><br><br>

        <h3>Selecione as Questões:</h3>

        <!-- Campo de pesquisa -->
        <input type="search" id="searchInput" onkeyup="filterTable()"
            placeholder="Pesquise por ID, pergunta, tipo, etc."><br>

        <table id="questionsTable">
            <thead>
                <tr>
                    <th>Selecionar</th>
                    <th>ID</th>
                    <th>Pergunta</th>
                    <th>Tipo</th>
                    <th>Ano</th>
                    <th>Nível</th>
                    <th>Grau</th>
                    <th>Assunto</th>
                    <th>Banca</th>
                    <th>Função</th>
                    <th>Cargo</th>
                    <th>Curso</th>
                    <th>Disciplina</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="questions[]" value="<?php echo $row['ID']; ?>"
                            <?php echo in_array($row['ID'], $questions) ? 'checked' : ''; ?>>
                    </td>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['question']; ?></td>
                    <td><?php echo strtoupper($row['question_type']); ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td><?php echo $row['grade_level']; ?></td>
                    <td><?php echo searchName($mysqli, 'subject', 'subjects', $row['subject']); ?></td>
                    <td><?php echo searchName($mysqli, 'banca', 'bancas', $row['banca']); ?></td>
                    <td><?php echo searchName($mysqli, 'job_function', 'job_functions', $row['job_function']); ?></td>
                    <td><?php echo searchName($mysqli, 'job_role', 'job_roles', $row['job_role']); ?></td>
                    <td><?php echo searchName($mysqli, 'course', 'courses', $row['course']); ?></td>
                    <td><?php echo searchName($mysqli, 'discipline', 'disciplines', $row['discipline']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
    </form>
</body>

</html>