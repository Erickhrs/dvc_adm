<?php
// Inclui a conexão com o banco de dados e a proteção
include('../includes/connection.php');
include('../includes/protect.php');

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['questionID'], $_POST['type'])) {
    $questionID = $_POST['questionID'];
    $type = $_POST['type'];

    // Verifica o tipo e atualiza a coluna 'ok' para 1
    if ($type == 'comments') {
        $update_query = "UPDATE comments SET ok = 1 WHERE ID = ?";
    } else if ($type == 'feedbacks') {
        $update_query = "UPDATE feedbacks SET ok = 1 WHERE id = ?";
    } else {
        die("Tipo inválido.");
    }

    // Prepara a declaração
    if ($stmt = $mysqli->prepare($update_query)) {
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $stmt->close();
    }

    // Retorna uma resposta ao cliente
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
}
?>