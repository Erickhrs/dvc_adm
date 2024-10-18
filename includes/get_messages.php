<?php
// Inclui a conexão com o banco de dados e a proteção
include('connection.php');
include('protect.php');
include('functions.php');

// Busca os dados da tabela comments
$query_comments = "SELECT ID, question_ID, user_ID, picture, comment, created_at FROM comments WHERE ok <> 1";
$result_comments = $mysqli->query($query_comments);

// Busca os dados da tabela feedbacks
$query_feedbacks = "SELECT id, user_ID, question_ID, feedback, created_at FROM feedbacks WHERE ok <> 1";
$result_feedbacks = $mysqli->query($query_feedbacks);

// Exibindo os dados dos comentários
echo '<section class="comment-section">';
echo '<h2>Comments</h2>';
if ($result_comments->num_rows > 0) {
    echo '<ul>';
    while ($row = $result_comments->fetch_assoc()) {
        $whatsapp_number = searchName($mysqli, 'phone', 'users', $row['user_ID']);
        echo '<li style="display: flex; align-items: center; margin-bottom: 15px;">';
        
        // Parte da imagem e ID do usuário
        echo '<div style="display: flex; align-items: center; margin-right: 20px; min-width: 180px; max-width: 180px;">';
        echo '<img src="' . $row['picture'] . '" alt="User Picture" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">';
        echo '<span><strong>' . searchName($mysqli, 'name', 'users', $row['user_ID']) . '</strong></span>';
        echo '</div>';
        
        // Parte do comentário e data
        echo '<div>';
        echo '<p style="width: fit-content; background-color: #65a00d; color: white; padding: 2px; border-radius: 8px; font-size: 11px;">' . $row['question_ID'] . '</p>';
        echo '<p>' . $row['comment'] . '</p>';
        echo '<p style="font-size: 0.9em; color: gray;">' . $row['created_at'] . '</p>';
        echo '</div>';
        
        // Botões
        echo '<div style="margin-left: auto; display: flex; gap: 10px;">';
        $user_email = searchName($mysqli, 'email', 'users', $row['user_ID']);
        echo '<a target="_blank" href="send_email.php?email=' . urlencode($user_email) . '" style="text-decoration: none;">';
        echo '<button style="background-color: #f39c12; color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;"><i class="bx bx-envelope"></i></button>';
        echo '</a>';
        echo '<a href="https://wa.me/' . $whatsapp_number . '?" target="_blank" style="text-decoration: none;">';
        echo '<button style="background-color: #25d366; color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;"><i class="bx bxl-whatsapp"></i></button>';
        echo '</a>';
        
        // Botão de confirmação usando data attributes
        echo '<button data-id="' . $row['ID'] . '" data-type="comments" class="confirm-view-button" style="background-color: #007bff; color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;">
            <i class="bx bx-check"></i>
          </button>';
        
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No comments found.</p>';
}
echo '</section>';

// Exibindo os dados dos feedbacks
echo '<section class="feedback-section">';
echo '<h2>Feedbacks</h2>';
if ($result_feedbacks->num_rows > 0) {
    echo '<ul>';
    while ($row = $result_feedbacks->fetch_assoc()) {
        $whatsapp_number = searchName($mysqli, 'phone', 'users', $row['user_ID']);
        echo '<li>';
        echo '<p><i class="bx bxs-flag-alt"></i>' . searchName($mysqli, 'name', 'users', $row['user_ID']) . '</p>';
        echo '<p>' . $row['question_ID'] . '</p>';
        echo '<p style="max-width: 300px; word-wrap: break-word; word-break: break-word; height: auto;">' . $row['feedback'] . '</p>';
        echo '<p style="font-size: 0.9em; color: gray;">' . $row['created_at'] . '</p>';
        
        // Botões
        echo '<div style="display: flex; gap: 10px;">';
        $user_email = searchName($mysqli, 'email', 'users', $row['user_ID']);
        echo '<a target="_blank" href="send_email.php?email=' . urlencode($user_email) . '" style="text-decoration: none;">';
        echo '<button style="background-color: #f39c12; color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;"><i class="bx bx-envelope"></i></button>';
        echo '</a>';
        echo '<a target="_blank" href="question.php?id=' . $row['question_ID'] . '" style="text-decoration: none;">';
        echo '<button style="background-color: #007bff; color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;"><i class="bx bx-book-open"></i></button>';
        echo '</a>';
        echo '<a href="https://wa.me/' . $whatsapp_number . '?" target="_blank" style="text-decoration: none;">';
        echo '<button style="background-color: #25d366; color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;"><i class="bx bxl-whatsapp"></i></button>';
        echo '</a>';
        
        // Botão de confirmação usando data attributes
        echo '<button data-id="' . $row['id'] . '" data-type="feedbacks" class="confirm-view-button" style="background-color: #007bff; color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;">
        <i class="bx bx-check"></i>
      </button>';
        
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No feedbacks found.</p>';
}
echo '</section>';
?>