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

$question = isset($_POST['question']) ? $_POST['question'] : "";
$related_contents = isset($_POST['related_contents']) ? $_POST['related_contents'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : "";
$keys = isset($_POST['keys']) ? $_POST['keys'] : "";
$subject = isset($_POST['subject']) ? $_POST['subject'] : "";
$banca = isset($_POST['banca']) ? $_POST['banca'] : "";
$job_role = isset($_POST['job_role']) ? $_POST['job_role'] : "";
$level = isset($_POST['level']) ? $_POST['level'] : "";
$question_type = 'tf';
$adms_ID = $_SESSION['id'];
$status = 1;
$answer = $_POST['OTF'];

$course = isset($_POST['course']) ? formatSelectedValues($_POST['course']) : '';
$discipline = isset($_POST['discipline']) ? formatSelectedValues($_POST['discipline']) : '';
$job_function = isset($_POST['job_function']) ? formatSelectedValues($_POST['job_function']) : '';
$grade_level = isset($_POST['grade_level']) ? formatSelectedValues($_POST['grade_level']) : '';

echo "Cursos selecionados: " . htmlspecialchars($course) . "<br>";
echo "Disciplinas selecionadas: " . htmlspecialchars($discipline) . "<br>";
echo "Atuação selecionada: " . htmlspecialchars($job_function) . "<br>";
echo "Níveis selecionados: " . htmlspecialchars($grade_level) . "<br>";

//---------------------------------------------------------------

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
    $job_role, $grade_level, $course, $question_type, $level, $adms_ID, $job_function, $status, $answer
);

if ($stmt->execute()) {
    echo "Novo registro inserido com sucesso!";
} else {
    echo "Erro ao inserir o registro: " . $stmt->error;
}


$stmt->close();
     
?>