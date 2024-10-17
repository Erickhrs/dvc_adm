<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload e Visualização de Excel</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    /* Navbar */
    .navbar {
        background-color: #007bff;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
    }

    .navbar h1 {
        margin: 0;
        font-size: 24px;
    }

    .navbar form {
        display: flex;
        align-items: center;
    }

    .navbar label {
        font-size: 16px;
        margin-right: 10px;
        color: white;
    }

    .navbar input[type="file"] {
        padding: 10px;
        border: none;
        background-color: white;
        border-radius: 5px;
        margin-right: 10px;
    }

    .navbar button {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .navbar button:hover {
        background-color: #218838;
    }

    /* Estilo principal */
    main {
        margin-top: 100px;
        padding: 20px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
        display: flex !important;
        justify-content: center !important;
    }

    #result {
        padding: 20px;
        border-radius: 8px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 16px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    td {
        background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar form {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar input[type="file"] {
            margin-bottom: 10px;
        }

        main {
            padding: 15px;
            display: flex !important;
            justify-content: center !important;
        }

        table,
        th,
        td {
            font-size: 14px;
        }
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>Upload e Edição de Planilha</h1>
        <form action="./actions/upload_mult.php" method="post" enctype="multipart/form-data">
            <label for="excelFile">Escolha o arquivo Excel:</label>
            <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
            <button type="submit">Upload</button>
        </form>
    </div>

    <!-- Conteúdo Principal -->
    <main>
        <div id="result">
            <button id="submit-data" onclick="submitData()">Enviar Dados para o Banco de Dados</button>
            <?php
session_start(); // Inicie a sessão no início do arquivo

// Exibe os dados se estiverem na sessão
if (isset($_SESSION['data'])) {
    echo "<h2>Dados do Excel:</h2>";
    echo $_SESSION['data'];  // Exibe a tabela de dados armazenada na sessão
    unset($_SESSION['data']); // Limpa os dados da sessão após exibir
}
?>

        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('data-table');
        const cells = table.querySelectorAll('td');

        // Permitir a edição de células ao clicar nelas usando SweetAlert2
        cells.forEach(cell => {
            cell.addEventListener('click', function() {
                const currentText = this.innerText;

                Swal.fire({
                    title: 'Edite o valor',
                    input: 'textarea',
                    inputValue: currentText,
                    showCancelButton: true,
                    confirmButtonText: 'Salvar',
                    cancelButtonText: 'Cancelar',
                    inputAttributes: {
                        'aria-label': 'Edite o valor da célula'
                    },
                    inputValidator: (value) => {
                        if (!value) {
                            return 'O campo não pode estar vazio!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.innerText = result.value;
                        Swal.fire({
                            title: 'Salvo!',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    });

    function submitData() {
        const submitButton = document.getElementById('submit-data');

        // Desabilita o botão para evitar múltiplos envios
        submitButton.disabled = true;
        submitButton.innerText = 'Enviado';

        const table = document.getElementById('data-table');
        const rows = table.getElementsByTagName('tr');
        const data = [];

        // Ignora a primeira linha (cabeçalhos)
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            const rowData = {};

            for (let j = 0; j < cells.length; j++) {
                const header = table.getElementsByTagName('th')[j].innerText;
                rowData[header] = cells[j].innerText;
            }

            data.push(rowData);
        }

        // Envia os dados via AJAX
        fetch('./actions/insert_questions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                Swal.fire({
                    title: result.message,
                    icon: result.success ? 'success' : 'error',
                    timer: 1500,
                    showConfirmButton: false
                });

                if (!result.success) {
                    // Reabilita o botão se houver erro
                    submitButton.disabled = false;
                    submitButton.innerText = 'Enviar Dados para o Banco de Dados';
                }
            })
            .catch(error => {
                console.error('Erro:', error);

                // Reabilita o botão em caso de erro na requisição
                submitButton.disabled = false;
                submitButton.innerText = 'Enviar Dados para o Banco de Dados';
            });
    }
    </script>
</body>

</html>