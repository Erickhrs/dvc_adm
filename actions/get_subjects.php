<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, subject FROM subjects";
$result = $mysqli->query($sql);

if ($result->num_rows>0){
echo '<option value="">Escolha um Assunto</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ID'] . '">' . $row['subject'] . '</option>';
}
}  else {
    echo '<option value="">Nenhum assunto encontrado</option>';
}

$mysqli->close();

?>