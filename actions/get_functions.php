<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, function FROM functions";
$result = $mysqli->query($sql);

if ($result->num_rows>0){
echo '<option value="">Escolha a atuação</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ID'] . '">' . $row['discipline'] . '</option>';
}
}  else {
    echo '<option value="">Nenhuma atuação encontrada</option>';
}

$mysqli->close();

?>