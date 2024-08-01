<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, subject FROM subjects";
$result = $mysqli->query($sql);

if ($displayType == 'option') {
    if ($result->num_rows>0){
        echo '<option value="">Escolha um Assunto</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['ID'] . '">' . $row['subject'] . '</option>';
        }
        }  else {
            echo '<option value="">Nenhum assunto encontrado</option>';
        }
        
}
else if ($displayType == 'list') {
    if ($result->num_rows > 0) {
        echo '<thead><tr><th>ID</th><th>Disciplina</th></tr></thead>';
        while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . '#' . $row['ID'] .'</td><td>' . $row['subject'] . '</td></tr>';
        }
    } else {
        echo 'Nada';
    }
} 



$mysqli->close();

?>