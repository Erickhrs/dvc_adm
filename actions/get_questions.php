<?php
include('./includes/connection.php');
include('./includes/protect.php');

$sql = "SELECT ID, question, adms_ID, created_at, status FROM questions";
$result = $mysqli->query($sql);

if ($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
    echo '<tr>
                    <td class="questionTD">
                        <p>' . $row['question'] .'</p>
                    </td>
                    <td class="answerTD">
                        <p>RESPOSTA A</p>
                    </td>
                    <td>
                        <img src="/assets/people.png">
                        <p>John Doe</p>
                    </td>
                    <td>'. $row['created_at'] . '</td>
                    <td><span class="status completed">'. $row['status'] . '</span></td>
                    <td><i class="bx bx-edit editIcon"></i></td>
                </tr>';
}
}  else {
    echo '<option value="">Nenhum formação encontrada</option>';
}

$mysqli->close();

?>