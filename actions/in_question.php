<?php
include_once('../includes/connection.php');
include_once('../includes/protect.php');
$displayCode = 'hide';
include_once('../actions/get_nxtCode.php');
var_dump($_POST);
echo $next_id;



//$sql = ("INSERT INTO `questions` (`ID`, `question`, `year`, `related_contents`, `keys`, `discipline`, `subject`, `banca`, `job_role`, `grade_level`, `course`, `question_type`, `level`, `adms_ID`, `job_function`, `created_at`, `status`) VALUES ();");
?>