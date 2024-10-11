<?php
function searchName($mysqli, $name, $table, $id) {
    // Verifica se o ID contém "-"
    if (strpos($id, '-') !== false) {
        // Separa os IDs
        $ids = explode('-', $id);
        $names = [];

        // Busca o nome correspondente a cada ID
        foreach ($ids as $single_id) {
            $sql = "SELECT $name FROM $table WHERE ID = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $single_id);
            $stmt->execute();
            $resultName = $stmt->get_result();

            if ($resultName->num_rows > 0) {
                $final = $resultName->fetch_assoc();
                $names[] = $final[$name];
            } else {
                $names[] = 'ERRO';
            }
            $stmt->close();
        }

        // Retorna os dois nomes separados por "-"
        return implode(' - ', $names);
    } else {
        // Caso tenha apenas um ID, busca o nome normalmente
        $sql = "SELECT $name FROM $table WHERE ID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultName = $stmt->get_result();

        if ($resultName->num_rows > 0) {
            $final = $resultName->fetch_assoc();
            $stmt->close();
            return $final[$name];
        } else {
            $stmt->close();
            return 'ERRO';
        }
    }
}

?>