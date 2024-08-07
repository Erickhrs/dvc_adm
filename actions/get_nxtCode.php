<?php
$sql = "SELECT id FROM questions ORDER BY id DESC LIMIT 1";
$result = $mysqli->query($sql);

if ($result) {
    $row = $result->fetch_assoc(); 
    $last_id = $row['id'];
    $last_number = intval(str_replace('DVCQ', '', $last_id));
    $next_number = $last_number + 1;
    $next_id = 'DVCQ' . $next_number;

    if ($displayCode != 'hide') {
        echo $next_id;
    }
} else {
    echo "ERRO";
}

?>