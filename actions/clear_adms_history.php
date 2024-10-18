<?php
// Inclui arquivos necessários
include('../includes/connection.php');  // Conexão com o banco de dados
include('../includes/protect.php');     // Proteção de acesso
include('../includes/history.php');     // Função para registrar histórico

// Verifica se o usuário tem permissão para limpar o histórico
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Acesso negado
    echo json_encode(['error' => 'Acesso negado']);
    exit;
}

try {
    // Limpa a tabela adms_history
    $sql = "DELETE FROM adms_history";
    if ($mysqli->query($sql) === TRUE) {
        // Registra o evento de limpeza no histórico
        newHistoryEvent($_SESSION['id'], "Limpou o histórico", date('Y-m-d H:i:s'), 'ALTA');

        // Retorna sucesso
        http_response_code(200);
        echo json_encode(['message' => 'Histórico limpo com sucesso']);
    } else {
        // Erro ao limpar o histórico
        throw new Exception("Erro ao limpar o histórico.");
    }
} catch (Exception $e) {
    // Captura qualquer erro e retorna uma mensagem apropriada
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$mysqli->close();
?>