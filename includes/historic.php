<?php
include('protect.php');
    function newHistoricEvent($adm_id, $description, $when, $importance){
    include('connection.php');
    $sql = "SELECT * FROM adms WHERE ID = $adm_id";
    $sql_query = $mysqli->query($sql) or die ("Erro ao buscar o administrador: ".$mysqli->error);

    if ($sql_query->num_rows == 1){
        $sql = "INSERT INTO adms_historic (adms_ID, description, occurred_at, importance) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("isss", $adm_id, $description, $when, $importance);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }
    else{
        header('Location: ../erro.php');
    }
    }
?>