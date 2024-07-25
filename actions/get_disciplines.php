<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, discipline FROM disciplines";
$result = $mysqli->query($sql);

if ($result->num_rows>0){
echo '<option value="">Escolha uma Disciplina</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ID'] . '">' . $row['discipline'] . '</option>';
}
}  else {
    echo '<option value="">Nenhuma disciplina encontrada</option>';
}

$mysqli->close();

?>