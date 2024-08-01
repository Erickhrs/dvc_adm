<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, job_function FROM job_functions";
$result = $mysqli->query($sql);

if ($displayType == 'option') {
    if ($result->num_rows > 0) {
        echo '<option value="">Escolha uma atuação</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['ID'] . '">' . $row['job_function'] . '</option>';
        }
    } else {
        echo '<option value="">Nenhuma atuação encontrada</option>';
    }
} else if ($displayType == 'list') {
    if ($result->num_rows > 0) {
        echo '<thead><tr><th>ID</th><th>Disciplina</th></tr></thead>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr><td>' . '#' . $row['ID'] . '</td><td>' . $row['job_function'] . '</td></tr>';
        }
    } else {
        echo 'Vazio';
    }
}



$mysqli->close();