<?php
// Inclui a conexão com o banco de dados e a proteção
include('connection.php');
include('protect.php');

// Busca os dados da tabela comments
$query_comments = "SELECT question_ID, user_ID, picture, comment, created_at FROM comments";
$result_comments = $mysqli->query($query_comments);

// Busca os dados da tabela feedbacks
$query_feedbacks = "SELECT user_ID, question_ID, feedback, created_at FROM feedbacks";
$result_feedbacks = $mysqli->query($query_feedbacks);

// Exibindo os dados dos comentários
echo '<section class="comment-section">';
echo '<h2>Comments</h2>';
if ($result_comments->num_rows > 0) {
    echo '<ul>';
    while($row = $result_comments->fetch_assoc()) {
        echo '<li>';
        echo '<p><strong>Question ID:</strong> ' . $row['question_ID'] . '</p>';
        echo '<p><strong>User ID:</strong> ' . $row['user_ID'] . '</p>';
        echo '<p><strong>Picture:</strong> <img src="' . $row['picture'] . '" alt="User Picture" style="width:50px;height:50px;"></p>';
        echo '<p><strong>Comment:</strong> ' . $row['comment'] . '</p>';
        echo '<p><strong>Created at:</strong> ' . $row['created_at'] . '</p>';
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
    while($row = $result_feedbacks->fetch_assoc()) {
        echo '<li>';
        echo '<p><strong>User ID:</strong> ' . $row['user_ID'] . '</p>';
        echo '<p><strong>Question ID:</strong> ' . $row['question_ID'] . '</p>';
        echo '<p><strong>Feedback:</strong> ' . $row['feedback'] . '</p>';
        echo '<p><strong>Created at:</strong> ' . $row['created_at'] . '</p>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No feedbacks found.</p>';
}
echo '</section>';
?>