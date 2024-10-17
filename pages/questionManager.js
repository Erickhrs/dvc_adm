export default () => {
    const updateCounters = async () => {
        try {
            const response = await fetch('./actions/counts.php');
            const data = await response.json();
            document.querySelector('#TotalQuestions').textContent = data.totalQuestions;
            document.querySelector('#TotalDesaQuestions').textContent = data.totalDesaQuestions; 
        } catch (error) {
            console.error('Error fetching count:', error);
        }
    };

    const fetchQuestions = async (filter = '') => {
        try {
            const response = await fetch('./actions/get_questions.php');
            const data = await response.json();
            const tbody = document.getElementById('questionTB');
            tbody.innerHTML = '';
            if (data.length > 0) {
                const filteredData = data.filter(question => 
                    question.question.toLowerCase().includes(filter.toLowerCase()) || 
                    question.answer.toLowerCase().includes(filter.toLowerCase())
                );

                if (filteredData.length > 0) {
                    filteredData.forEach(data => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="questionTD"><p style="width: fit-content;text-align: left;overflow-y: auto;max-width;margin-left: auto; margin-right: auto;">${data.question}</p></td>
                            <td>${data.answer}</td>
                            <td>${data.adms_id}</td>
                            <td>${data.created_at}</td>
                            <td class='${data.status}_status'>${data.status}</td>
                        `;
                        tr.querySelector('.questionTD').addEventListener('click', () => {
                            window.location.href = `./question.php?id=${data.ID}`;
                        });

                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="4">Nenhuma questão encontrada.</td></tr>';
                }
            } else {
                tbody.innerHTML = '<tr><td colspan="4">Nenhuma questão encontrada.</td></tr>';
            }
        } catch (error) {
            console.error('Erro ao carregar as questões:', error);
        }
    };

    // Função para lidar com o filtro ao digitar
    const handleSearch = (event) => {
        const filter = event.target.value;
        fetchQuestions(filter);
    };

    // Criando o template HTML com o campo de pesquisa
    const container = document.createElement('div');
    const template = `
        <div class="head-title">
            <div class="left">
                <h1>Gerenciador de Questões</h1>
                <ul class="breadcrumb">
                    <li>
                        <a>Gerenciador Questões</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active">Painel</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="table-data">
            <div class="order" style="padding:0px!important;background-color:transparent!important;">
                <div class="head" style="margin-bottom:0px!important">
                    <a href="./newQuestion.php" class="newQuestionBtn"><i class='bx bx-plus'></i>Nova questão</a>
                    <a href="./upload_mult.php" class="newQuestionBtn"><i class='bx bx-upload'></i>Upload em Massa<a>
                     <a href="./upload_tf.php" class="newQuestionBtn"><i class='bx bx-upload'></i>Upload em Massa VF<a>
                    <a href="./disciplines.php" class="newQuestionBtn"><i class='bx bx-plus'></i>Novo atributo<a>
                    <a href="./newExam.php" class="newQuestionBtn"><i class='bx bx-plus'></i>Novo Simulado<a>
                    <a href="./exams_list.php" class="newQuestionBtn"><i class='bx bx-book-open'></i>Gerenciar Simulados<a>  
                </div>
            </div>
        </div>

        <ul class="box-info">
            <li>
                <i class='bx bxs-layer'></i>
                <span class="text">
                    <h3 id="TotalQuestions">0</h3>
                    <p>Questões ativas</p>
                </span>
            </li>
             <li>
                <i class='bx bxs-layer'></i>
                <span class="text">
                    <h3 id="TotalDesaQuestions">0</h3> <!-- Adicione este bloco -->
                    <p>Questões desativadas</p>
                </span>
            </li>
        </ul>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Resultados</h3>
                    <input type="text" id="searchInput" placeholder="Filtrar perguntas..." style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #ccc;">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Resposta</th>
                            <th>Criado por</th>
                            <th>Data Criação</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="questionTB">
                        <tr>
                            <td colspan="5">Carregando...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `;

    // Adiciona o HTML ao container
    container.innerHTML = template;

    // Adiciona o evento de filtro
    const searchInput = container.querySelector('#searchInput');
    searchInput.addEventListener('input', handleSearch);

    // Carrega as questões
    fetchQuestions();
    updateCounters();

    return container;
};
