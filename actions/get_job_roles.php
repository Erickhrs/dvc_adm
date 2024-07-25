<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, job_role FROM job_roles";
$result = $mysqli->query($sql);

if ($result->num_rows>0){
echo '<option value="">Escolha uma cargo</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ID'] . '">' . $row['discipline'] . '</option>';
}
}  else {
    echo '<option value="">Nenhum cargo encontrado</option>';
}

$mysqli->close();

?>