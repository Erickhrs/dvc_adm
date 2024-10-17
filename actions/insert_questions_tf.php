<?php
include_once('../includes/connection.php');
include_once('../includes/protect.php');
include_once('../includes/history.php');
$displayCode = 'hide';
include_once('../actions/get_nxtIdMult.php');

header('Content-Type: application/json');

$adms_ID = $_SESSION['id'];
$type = "tf";
$status = "1";
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    foreach ($data as $row) {
        // Validações
        $year = $row['year'];
        $level = $row['level'];
        $subject = $row['subject'];
        $banca = $row['banca'];
        $answer = strtoupper($row['answer']); // Converte para maiúsculas para garantir a comparação correta

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

      // Validação da resposta (deve ser 0 ou 1)
      if ($answer !== '0' && $answer !== '1') {
        echo json_encode(['success' => false, 'message' => 'A resposta deve ser 0 (falso) ou 1 (verdadeiro).']);
        exit;
    }

        // Captura a data e hora atual para o campo created_at
        $created_at = date('Y-m-d H:i:s');

        // Inserção da questão na tabela questions
        $stmt = $mysqli->prepare("INSERT INTO questions (ID, question, question_type, status, year, level, grade_level, created_at, subject, banca, job_function, job_role, course, discipline, related_contents, `keys`, answer, prof_comment, adms_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            'ssssisssssssssssssi',
            $next_id, $row['question'], $type, $status, $year, $level, $row['grade_level'], $created_at,
            $subject, $banca, $row['job_function'], $row['job_role'], $row['course'],
            $row['discipline'], $row['related_contents'], $row['keys'], $answer, $row['prof_comment'],
            $adms_ID
        );

        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados: ' . $stmt->error]);
            exit;
        }

        $questions_ID = $next_id; // Obter o ID da questão inserida
        $next_id = getNextID($mysqli, $displayCode);
    }

    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido.']);
}
?>