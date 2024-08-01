<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, job_role FROM job_roles";
$result = $mysqli->query($sql);

if ($displayType == 'option') {
    if ($result->num_rows>0){
        echo '<option value="">Escolha um cargo</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['ID'] . '">' . $row['job_role'] . '</option>';
        }
        }  else {
            echo '<option value="">Nenhum cargo encontrado</option>';
        }
        
}
else if ($displayType == 'list') {
    if ($result->num_rows > 0) {
        echo '<thead><tr><th>ID</th><th>Disciplina</th></tr></thead>';
        while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . '#' . $row['ID'] .'</td><td>' . $row['job_role'] . '</td></tr>';
        }
    } else {
        echo 'Nada';
    }
} 



$mysqli->close();

?>