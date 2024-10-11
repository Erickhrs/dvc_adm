<?php
include('../includes/connection.php');
include('../includes/protect.php');
include('../includes/history.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = $_POST['id'];  // ID da questão a ser excluída

    // Iniciar uma transação para garantir que todas as exclusões sejam realizadas ou revertidas em caso de erro
    $mysqli->begin_transaction();

    try {
    
        // Excluir registros relacionados da tabela 'answers'
        $sql = "DELETE FROM answers WHERE questions_ID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $question_id);
        $stmt->execute();
        
 // Excluir registros relacionados da tabela 'users_answers' que fazem referência à questão
        $sql = "DELETE FROM users_answers WHERE question_ID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $question_id);
        $stmt->execute();

        // Excluir registros relacionados da tabela 'users_like'
        $sql = "DELETE FROM users_likes WHERE question_ID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $question_id);
        $stmt->execute();

        // Excluir registros relacionados da tabela 'users_notes'
        $sql = "DELETE FROM users_notes WHERE question_ID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $question_id);
        $stmt->execute();

        // Agora que todas as dependências foram removidas, exclua a questão da tabela 'questions'
        $sql = "DELETE FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $question_id);
        $stmt->execute();

        // Commit da transação
        $mysqli->commit();

        echo "Questão excluída com sucesso!";
        header('Location: ../system.php');
        newHistoryEvent($_SESSION['id'], "Excluiu uma questão (". $_POST['id'] . ")", date('Y-m-d H:i:s'), 'ALTA');
    } catch (Exception $e) {
        // Em caso de erro, reverter a transação
        $mysqli->rollback();
        echo "Erro ao excluir a questão: " . $e->getMessage();
    }

} else {
    echo "Método inválido.";
}
?>