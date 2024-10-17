<?php
include_once('../includes/connection.php');
include_once('../includes/protect.php');
include_once('../includes/history.php');
$displayCode = 'hide';
include_once('../actions/get_nxtIdMult.php');

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

        // Validação da resposta (apenas um caractere)
        if (strlen($answer) !== 1) {
            echo json_encode(['success' => false, 'message' => 'A resposta deve ser apenas um caractere.']);
            exit;
        }

        // Verifica se as alternativas A, B, C e D estão preenchidas (obrigatórias)
        if (empty($row['alternative_a']) || empty($row['alternative_b']) || empty($row['alternative_c']) || empty($row['alternative_d'])) {
            echo json_encode(['success' => false, 'message' => 'As alternativas A, B, C e D são obrigatórias e não podem estar vazias.']);
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

        // Inserção das alternativas na tabela answers
        $alternatives = [
            'A' => $row['alternative_a'],
            'B' => $row['alternative_b'],
            'C' => $row['alternative_c'],
            'D' => $row['alternative_d'],
            'E' => $row['alternative_e'] // E é opcional
        ];

        foreach ($alternatives as $alt => $content) {
            // A alternativa E é opcional, então só verifica as outras para validação
            if ($alt !== 'E' && empty($content)) {
                echo json_encode(['success' => false, 'message' => 'Alternativa ' . $alt . ' está vazia e é obrigatória.']);
                exit;
            }

            // Verifica se a alternativa está preenchida para ser inserida
            if (!empty($content)) {
                $is_correct = ($alt === $answer) ? 1 : 0; // Verifica se a alternativa é a correta
                $stmt_alt = $mysqli->prepare("INSERT INTO answers (questions_ID, alternative, answer, correct) VALUES (?, ?, ?, ?)");
                $stmt_alt->bind_param('ssss', $questions_ID, $alt, $content, $is_correct);
                
                if (!$stmt_alt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Erro ao inserir alternativa: ' . $stmt_alt->error]);
                    exit;
                }
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido.']);
}
?>