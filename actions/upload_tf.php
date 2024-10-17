<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
session_start(); // Inicie a sessão no início do arquivo

// Verifica se o arquivo foi enviado
if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
    $file = $_FILES['excelFile']['tmp_name'];

    // Verifica se o arquivo foi movido corretamente
    if (is_uploaded_file($file)) {
        try {
            // Carregar o arquivo Excel
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Iniciar uma string para a tabela HTML
            $htmlTable = '<table id="data-table">';
            $htmlTable .= '<tr>';
            
            // Criar cabeçalhos da tabela (primeira linha do Excel) - Limite para 10 colunas
            foreach (array_slice($data[0], 0, 14) as $header) {
                $htmlTable .= "<th>" . htmlspecialchars($header) . "</th>";
            }
            $htmlTable .= '</tr>';
            
            // Criar as linhas com os dados
            for ($i = 1; $i < count($data); $i++) {
                $htmlTable .= '<tr>';
                foreach (array_slice($data[$i], 0, 14) as $cell) {
                    $htmlTable .= "<td>" . htmlspecialchars($cell) . "</td>";
                }
                $htmlTable .= '</tr>';
            }
            
            $htmlTable .= '</table>';
            
            // Armazenar a tabela em uma variável de sessão
            $_SESSION['data'] = $htmlTable;

            // Redirecionar de volta para a página inicial
            header('Location: ../upload_tf.php');
            exit(); // Adicione exit após o redirecionamento
        } catch (Exception $e) {
            echo "Erro ao carregar o arquivo Excel: " . $e->getMessage();
        }
    } else {
        echo "Erro no upload do arquivo.";
    }
} else {
    echo "Nenhum arquivo enviado ou ocorreu um erro no upload.";
}