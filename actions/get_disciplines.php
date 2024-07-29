<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, discipline FROM disciplines";
$result = $mysqli->query($sql);

if ($displayType == 'option') {
    if ($result->num_rows > 0) {
        echo '<option value="">Escolha uma Disciplina</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['ID'] . '">' . $row['discipline'] . '</option>';
        }
    } else {
        echo '<option value="">Nenhuma disciplina encontrada</option>';
    }
}
else if ($displayType == 'list') {
    if ($result->num_rows > 0) {
        echo '<thead><tr><th>ID</th><th>Disciplina</th></tr></thead>';
        while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . '#' . $row['ID'] .'</td><td>' . $row['discipline'] . '</td></tr>';
        }
    } else {
        echo 'Nada';
    }
}
$mysqli->close();