<?php
include('./includes/connection.php');
$id = 'DVCQ3';

$alternatives = array("A" => array(), "B" => array(), "C" => array(), "D" => array(), "E" => array());
$sql = "SELECT alternative, answer, correct FROM answers WHERE questions_ID = '$id'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // Processa cada linha do resultado
    while($row = $result->fetch_assoc()) {
        $alternative = $row["alternative"];
        if (array_key_exists($alternative, $alternatives)) {
            $alternatives[$alternative][] = array(
                "answer" => $row["answer"],
                "correct" => $row["correct"]
            );
        }
    }
} else {
    echo "Nenhuma resposta encontrada para o ID $id.";
}

$mysqli->close();

foreach ($alternatives["A"] as $info) {
    echo $info["answer"] . "\n";
}
?>