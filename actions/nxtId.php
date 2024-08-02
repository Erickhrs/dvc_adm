<?php
include_once('./includes/connection.php');

$sql = "SELECT MAX(id) AS max_id FROM questions";
$result = $mysqli->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $next_id = $row['max_id'] + 1;
    echo '#' . $next_id;
} else {
    echo "#?" . $mysqli->error;
}
?>