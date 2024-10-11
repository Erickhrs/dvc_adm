<?php
include('../includes/connection.php');
include('../includes/protect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_id = $_POST['id'];

    // Excluir o simulado com base no ID
    $sql = "DELETE FROM exams WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $exam_id);

    if ($stmt->execute()) {
        echo "Simulado excluído com sucesso!";
        header('Location: ../system.php');
    } else {
        echo "Erro ao excluir o simulado: " . $stmt->error;
    }
    
    $stmt->close();
    $mysqli->close();
} else {
    echo "Método inválido.";
}
?>