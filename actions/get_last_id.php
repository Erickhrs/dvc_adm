<?php
include('./includes/protect.php');
function getLastId($table)
{
    if ($table==="questions"){
        include('./includes/connection.php');
        $sql = "SELECT MAX(ID) FROM questions;";
        $sql_query  = $mysqli->query($sql) or die("Erro ao buscar id: " . $mysqli->error);
        return $sql_query;
    }
    else{
      
    }
}

?>