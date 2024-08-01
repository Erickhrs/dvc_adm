<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, banca FROM bancas";
$result = $mysqli->query($sql);

if ($displayType == 'option') {
    if ($result->num_rows>0){
        echo '<option value="">Escolha uma banca</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['ID'] . '">' . $row['banca'] . '</option>';
        }
        }  else {
            echo '<option value="">Nenhuma banca encontrada</option>';
        }
        
}
else if ($displayType == 'list') {
    if ($result->num_rows > 0) {
        echo '<thead><tr><th>ID</th><th>Banca</th></tr></thead>';
        while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . '#' . $row['ID'] .'</td><td>' . $row['banca'] . '</td></tr>';
        }
    } else {
        echo 'Nada';
    }
} 



$mysqli->close();

?>