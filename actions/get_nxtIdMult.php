<?php
function getNextID($mysqli, $displayCode) {
    // Obter o último ID inserido
    $sql = "SELECT id FROM questions ORDER BY id DESC LIMIT 1";
    $result = $mysqli->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $last_id = $row['id'];
        $last_number = intval(str_replace('DVCQ', '', $last_id));
        $next_number = $last_number + 1;
        $next_id = 'DVCQ' . $next_number;

        // Verificar se o ID já existe no banco de dados
        $check_sql = "SELECT id FROM questions WHERE id = ?";
        $stmt = $mysqli->prepare($check_sql);
        $stmt->bind_param("s", $next_id);
        $stmt->execute();
        $stmt->store_result();

        // Enquanto o ID já existir, incrementa o número até gerar um ID único
        while ($stmt->num_rows > 0) {
            $next_number++;
            $next_id = 'DVCQ' . $next_number;
            $stmt->bind_param("s", $next_id);
            $stmt->execute();
            $stmt->store_result();
        }

        // Retorna o próximo ID disponível
        return $next_id;
    } else {
        echo "ERRO ao buscar o último ID";
    }
}

// Exemplo de uso
$next_id = getNextID($mysqli, $displayCode);
if ($displayCode != 'hide') {
    echo $next_id;
}
?>