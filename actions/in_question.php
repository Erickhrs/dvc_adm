<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/protect.php');
$displayCode = 'hide';
include_once('../actions/get_nxtCode.php');
//var_dump($_POST);
//echo $next_id;

function formatSelectedValues($values) {
    if (is_array($values)) {
        return implode('-', $values); // Junta os valores com "-"
    }
    return '';
}

function isCorrect($correct, $value) {
    if ($correct == $value){
        return 1;
    } else {
        return 0;
    }
}

$question = isset($_POST['question']) ? $_POST['question'] : "";
$related_contents = isset($_POST['related_contents']) ? $_POST['related_contents'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : "";
$keys = isset($_POST['keys']) ? $_POST['keys'] : "";
$subject = isset($_POST['subject']) ? $_POST['subject'] : "";
$banca = isset($_POST['banca']) ? $_POST['banca'] : "";
$job_role = isset($_POST['job_role']) ? $_POST['job_role'] : "";
$level = isset($_POST['level']) ? $_POST['level'] : "";
$question_type = 'mult';
$adms_ID = $_SESSION['id'];
$status = 1;
$answer = $_POST['answer'];

$course = isset($_POST['course']) ? formatSelectedValues($_POST['course']) : '';
$discipline = isset($_POST['discipline']) ? formatSelectedValues($_POST['discipline']) : '';
$job_function = isset($_POST['job_function']) ? formatSelectedValues($_POST['job_function']) : '';
$grade_level = isset($_POST['grade_level']) ? formatSelectedValues($_POST['grade_level']) : '';

echo "Cursos selecionados: " . htmlspecialchars($course) . "<br>";
echo "Disciplinas selecionadas: " . htmlspecialchars($discipline) . "<br>";
echo "Atuação selecionada: " . htmlspecialchars($job_function) . "<br>";
echo "Níveis selecionados: " . htmlspecialchars($grade_level) . "<br>";

//---------------------------------------------------------------

$answerMapping = [
    'oa' => 'A',
    'ob' => 'B',
    'oc' => 'C',
    'od' => 'D',
    'oe' => 'E'
];
$correct = isset($answerMapping[$answer]) ? $answerMapping[$answer] : null;

$sql = "INSERT INTO `questions` (
    `ID`, `question`, `year`, `related_contents`, `keys`, `discipline`, `subject`, `banca`, 
    `job_role`, `grade_level`, `course`, `question_type`, `level`, `adms_ID`, `job_function`, `created_at`, `status`, `answer`
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?
)";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('Erro na preparação da declaração: ' . $mysqli->error);
}// Vincula os parâmetros
$stmt->bind_param(
    'sssssssssssssssis', // tipos dos parâmetros
    $next_id, $question, $year, $related_contents, $keys, $discipline, $subject, $banca, 
    $job_role, $grade_level, $course, $question_type, $level, $adms_ID, $job_function, $status, $correct
);

if ($stmt->execute()) {
    echo "Novo registro inserido com sucesso!";
    newHistoryEvent($_SESSION['id'], "Adicionou a questão (#". $ID . " - " . $name . ")", date('Y-m-d H:i:s'), 'ALTA');
} else {
    echo "Erro ao inserir o registro: " . $stmt->error;
}


//---------------------------------------------------------------


 
$alternative = "A";
$questionValue = isCorrect($answer, 'oa');
$oa = isset($_POST['oa']) ? $_POST['oa'] : "";

$sql = "INSERT INTO answers (questions_ID, alternative, answer, correct) VALUES (?, ?, ?,?)";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('Erro na preparação da declaração: ' . $mysqli->error);
}
$stmt->bind_param(
    'sssi', 
    $next_id, $alternative, $oa, $questionValue,
);

if ($stmt->execute()) {
    echo "Novos registros inserido com sucesso!";
} else {
    echo "Erro ao inserir os registros: " . $stmt->error;
}


$alternative = "B";
$questionValue = isCorrect($answer, 'ob');
$ob = isset($_POST['ob']) ? $_POST['ob'] : "";

$sql = "INSERT INTO answers (questions_ID, alternative, answer, correct) VALUES (?, ?, ?,?)";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('Erro na preparação da declaração: ' . $mysqli->error);
}
$stmt->bind_param(
    'sssi', 
    $next_id, $alternative, $ob, $questionValue,
);

if ($stmt->execute()) {
    echo "Novos registros inserido com sucesso!";
} else {
    echo "Erro ao inserir os registros: " . $stmt->error;
}

$alternative = "C";
$questionValue = isCorrect($answer, 'oc');
$oc = isset($_POST['oc']) ? $_POST['oc'] : "";

$sql = "INSERT INTO answers (questions_ID, alternative, answer, correct) VALUES (?, ?, ?,?)";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('Erro na preparação da declaração: ' . $mysqli->error);
}
$stmt->bind_param(
    'sssi', 
    $next_id, $alternative, $oc, $questionValue,
);

if ($stmt->execute()) {
    echo "Novos registros inserido com sucesso!";
} else {
    echo "Erro ao inserir os registros: " . $stmt->error;
}



$alternative = "D";
$questionValue = isCorrect($answer, 'od');
$od = isset($_POST['od']) ? $_POST['od'] : "";

$sql = "INSERT INTO answers (questions_ID, alternative, answer, correct) VALUES (?, ?, ?,?)";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('Erro na preparação da declaração: ' . $mysqli->error);
}
$stmt->bind_param(
    'sssi', 
    $next_id, $alternative, $od, $questionValue,
);

if ($stmt->execute()) {
    echo "Novos registros inserido com sucesso!";
} else {
    echo "Erro ao inserir os registros: " . $stmt->error;
}

$oe = isset($_POST['oe']) ? $_POST['oe'] : "";

 if ($oe !== "") {
    $alternative = "E";
$questionValue = isCorrect($answer, 'oe');


$sql = "INSERT INTO answers (questions_ID, alternative, answer, correct) VALUES (?, ?, ?,?)";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('Erro na preparação da declaração: ' . $mysqli->error);
}
$stmt->bind_param(
    'sssi', 
    $next_id, $alternative, $oe, $questionValue,
);

if ($stmt->execute()) {
    echo "Novos registros inserido com sucesso!";
} else {
    echo "Erro ao inserir os registros: " . $stmt->error;
}
}

$stmt->close();
     
?>