<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, banca FROM bancas";
$result = $mysqli->query($sql);

if ($result->num_rows>0){
echo '<option value="">Escolha uma banca</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ID'] . '">' . $row['discipline'] . '</option>';
}
}  else {
    echo '<option value="">Nenhuma banca encontrada</option>';
}

$mysqli->close();

?>