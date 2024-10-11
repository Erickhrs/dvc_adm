<?php
include('../includes/connection.php');
include('../includes/protect.php');
include('../includes/currentUserInfos.php');

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture o ID da pergunta a ser atualizada
    $question_id = $_POST['question_id'];
    
    if ($_POST['type'] == 'tf') {
        // Captura de dados do formulário para questões do tipo verdadeiro/falso
        $question = $_POST['question'];
        $prof_comment = $_POST['prof_comment'];
        $related_contents = $_POST['related_contents'];
        $answer = $_POST['answer'];
        
        // Atualizar a questão do tipo verdadeiro/falso
        $sql = "UPDATE questions 
                SET question = ?, prof_comment = ?, related_contents = ?, answer = ? 
                WHERE ID = ?";
        
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssss", $question, $prof_comment, $related_contents, $answer, $question_id);
        
        if ($stmt->execute()) {
            echo "Questão atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar a questão: " . $stmt->error;
        }
    } else if ($_POST['type'] == 'mult') {
        // Captura de dados do formulário para questões de múltipla escolha
        $question = $_POST['question'];
        $prof_comment = $_POST['prof_comment'];
        $related_contents = $_POST['related_contents'];
        $answers = $_POST['answers'];

        // Verificar se a matriz answers tem 4 ou 5 alternativas
        if (count($answers) < 4 || count($answers) > 5) {
            echo "Número de alternativas inválido. São permitidas 4 ou 5 alternativas.";
            exit;
        }

        // Atualizar a pergunta na tabela questions
        $sql = "UPDATE questions 
                SET question = ?, prof_comment = ?, related_contents = ? 
                WHERE ID = ?";
        
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssss", $question, $prof_comment, $related_contents, $question_id);
        
        if ($stmt->execute()) {
            echo "Questão atualizada com sucesso!";
            
            // Alternativas (A, B, C, D, E) correspondentes às posições do array de respostas
            $alternatives = ['A', 'B', 'C', 'D', 'E'];

            // Iterar sobre as respostas e atualizar a tabela answers
            foreach ($answers as $index => $answer) {
                $alternative_letter = $alternatives[$index]; // A, B, C, D, [E]

                // Atualizar a alternativa correspondente na tabela answers
                $update_answer_sql = "UPDATE answers 
                                      SET answer = ? 
                                      WHERE questions_ID = ? AND alternative = ?";
                
                $stmt_answer = $mysqli->prepare($update_answer_sql);
                $stmt_answer->bind_param("sss", $answer, $question_id, $alternative_letter);
                
                if ($stmt_answer->execute()) {
                    echo "Alternativa $alternative_letter atualizada com sucesso!<br>";
                } else {
                    echo "Erro ao atualizar a alternativa $alternative_letter: " . $stmt_answer->error . "<br>";
                }
            }
        } else {
            echo "Erro ao atualizar a questão: " . $stmt->error;
        }
    }
} else {
    echo "Método inválido.";
}
?>