<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, course FROM courses";
$result = $mysqli->query($sql);

if ($displayType == 'option') {
    if ($result->num_rows > 0) {
        echo '<option value="">Escolha a formação</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['ID'] . '">' . $row['course'] . '</option>';
        }
    } else {
        echo '<option value="">Nenhum formação encontrada</option>';
    }
} else if ($displayType == 'list') {
    if ($result->num_rows > 0) {
        echo '<thead><tr><th>ID</th><th>Formação</th></tr></thead>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr><td>' . '#' . $row['ID'] . '</td><td>' . $row['course'] . '</td></tr>';
        }
    } else {
        echo 'Vazio';
    }
}



$mysqli->close();