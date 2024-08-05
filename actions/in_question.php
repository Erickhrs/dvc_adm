<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/protect.php');
$displayCode = 'hide';
include_once('../actions/get_nxtCode.php');
//var_dump($_POST);
//echo $next_id;

$question = isset($_POST['question']) ? $_POST['question'] : "";
$related_contents = isset($_POST['related_contents']) ? $_POST['related_contents'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : "";
$keys = isset($_POST['keys']) ? $_POST['keys'] : "";
$discipline = isset($_POST['discipline']) ? $_POST['discipline'] : "";
$subject = isset($_POST['subject']) ? $_POST['subject'] : "";
$banca = isset($_POST['banca']) ? $_POST['banca'] : "";
$job_role = isset($_POST['job_role']) ? $_POST['job_role'] : "";
$grade_level = isset($_POST['grade_level']) ? $_POST['grade_level'] : "";
$course = isset($_POST['course']) ? $_POST['course'] : "";
$level = isset($_POST['level']) ? $_POST['level'] : "";
$job_function = isset($_POST['job_function']) ? $_POST['job_function'] : "";
$question_type = 'mult';
$adms_ID = $_SESSION['id'];
$status = 1;
$answer = $_POST['answer'];

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
    `job_role`, `grade_level`, `course`, `question_type`, `level`, `adms_ID`, `job_function`, `created_at`, `status`, `correct`
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
} else {
    echo "Erro ao inserir o registro: " . $stmt->error;
}


//---------------------------------------------------------------

function isCorrect($correct, $value) {
        if ($correct == $value){
            return 1;
        } else {
            return 0;
        }
    }
 
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