<?php
// Incluindo conexão e proteção
include('./includes/connection.php');
include('./includes/protect.php');

// Consultando todos os simulados, ordenados do mais recente para o mais antigo
$result = $mysqli->query("SELECT id, title, description, questions, created_at FROM exams ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulados Criados</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
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
        background-color: #f5f5f5;
        padding: 20px;
    }

    h1 {
        color: var(--main-color);
        text-align: center;
    }

    .filter-input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid var(--main-color);
        border-radius: 5px;
        box-sizing: border-box;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: var(--main-color);
        color: white;
    }

    tr:nth-child(even) {
        background-color: var(--green-todbg);
    }

    tr:hover {
        background-color: var(--light-green);
        color: white;
        cursor: pointer;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #888;
    }

    .edit-button,
    .delete-button {
        background: none;
        border: none;
        color: var(--main-color);
        cursor: pointer;
        font-size: 20px;
        display: flex;
        align-items: center;
    }

    .delete-button {
        color: red;
        margin-left: 10px;
    }
    </style>
</head>

<body>

    <h1>Simulados Criados</h1>

    <input type="text" id="searchInput" class="filter-input" placeholder="Filtrar simulados...">

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Questões</th>
                <th>Criado em</th>
                <th>Ações</th> <!-- Nova coluna para ações -->
            </tr>
        </thead>
        <tbody id="examsTableBody">
            <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['questions']); ?></td>
                <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($row['created_at']))); ?></td>
                <td style="display: flex;">
                    <form action="edit_exams.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="edit-button" title="Editar">
                            <i class="bx bx-edit"></i>
                        </button>
                    </form>

                    <!-- Botão de exclusão -->
                    <form action="./actions/delete_exam.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="delete-button" title="Excluir"
                            onclick="return confirm('Tem certeza que deseja excluir este simulado?');">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php else: ?>
            <tr>
                <td colspan="5" class="no-data">Nenhum simulado encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
    // Função para filtrar a tabela com base no valor do input
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var filter = this.value.toUpperCase();
        var rows = document.querySelectorAll('#examsTableBody tr');

        rows.forEach(function(row) {
            var title = row.cells[0].textContent.toUpperCase();
            var description = row.cells[1].textContent.toUpperCase();
            var questions = row.cells[2].textContent.toUpperCase();
            var createdAt = row.cells[3].textContent.toUpperCase();

            // Verifica se algum conteúdo da linha coincide com o filtro
            if (title.includes(filter) || description.includes(filter) || questions.includes(filter) ||
                createdAt.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    </script>

</body>

</html>