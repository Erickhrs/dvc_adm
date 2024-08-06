<?php

$sql = "SELECT COUNT(*) as total FROM questions";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $next_id = 'DVCQ' . $row['total'] + 1;
    if ($displayCode != 'hide'){
        echo $next_id; 
    }
       
} else {
    echo "#?";
}
?>