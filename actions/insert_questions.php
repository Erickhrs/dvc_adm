<?php
include_once('../includes/connection.php');
include_once('../includes/protect.php');
include_once('../includes/history.php');
$displayCode = 'hide';
include_once('../actions/get_nxtCode.php');

header('Content-Type: application/json');

$adms_ID = $_SESSION['id'];
$type = "mult";
$status = "1";
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    foreach ($data as $row) {
        // Validações
        $year = $row['year'];
        $level = $row['level'];
        $subject = $row['subject'];
        $banca = $row['banca'];
        $answer = $row['answer'];

        // Validação do ano (4 dígitos, apenas números)
        if (!preg_match('/^\d{4}$/', $year)) {
            echo json_encode(['success' => false, 'message' => 'O ano deve ter 4 dígitos e conter apenas números.']);
            exit;
        }

        // Validação do nível
        $valid_levels = ['medio', 'facil', 'dificil'];
        if (!in_array(strtolower($level), $valid_levels)) {
            echo json_encode(['success' => false, 'message' => 'O nível deve ser "medio", "facil" ou "dificil".']);
            exit;
        }

        // Validação do assunto e banca (sem letras)
        if (!preg_match('/^[0-9]*$/', $subject)) {
            echo json_encode(['success' => false, 'message' => 'O assunto não deve conter letras.']);
            exit;
        }
        if (!preg_match('/^[0-9]*$/', $banca)) {
            echo json_encode(['success' => false, 'message' => 'A banca não deve conter letras.']);
            exit;
        }

        // Validação da resposta (apenas um caractere)
        if (strlen($answer) !== 1) {
            echo json_encode(['success' => false, 'message' => 'A resposta deve ser apenas um caractere.']);
            exit;
        }

        // Prepare a consulta para evitar SQL Injection
        $stmt = $mysqli->prepare("INSERT INTO questions (ID, question, question_type, status, year, level, grade_level, created_at, subject, banca, job_function, job_role, course, discipline, related_contents, `keys`, answer, prof_comment, adms_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Associe os parâmetros com os dados da linha
        $stmt->bind_param(
            'ssssisssssssssssssi', // Tipos dos parâmetros, adicionado 'i' para adms_ID
            $next_id, $row['question'], $type, $status, $year, $level, $row['grade_level'], $row['created_at'],
            $subject, $banca, $row['job_function'], $row['job_role'], $row['course'],
            $row['discipline'], $row['related_contents'], $row['keys'], $answer, $row['prof_comment'],
            $adms_ID // Adicionando o ID do administrador aqui
        );

        if (!$stmt->execute()) {
            // Se falhar, retorna um erro
            echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados: ' . $stmt->error]);
            exit;
        }
        $next_id = getNextID($mysqli, $displayCode);
    }

    // Retorna sucesso
    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso!']);
} else {
    // Se não houver dados
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido.']);
}
?>