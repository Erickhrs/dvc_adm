<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, course FROM courses";
$result = $mysqli->query($sql);

if ($result->num_rows>0){
echo '<option value="">Escolha a formação</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ID'] . '">' . $row['discipline'] . '</option>';
}
}  else {
    echo '<option value="">Nenhum formação encontrada</option>';
}

$mysqli->close();

?>