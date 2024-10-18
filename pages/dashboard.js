export default () => {
    const updateCounters = async () => {
        try {
            const response = await fetch('./actions/counts.php');
            const data = await response.json();
            document.querySelector('#TotalQuestions').textContent = data.totalQuestions;
            document.querySelector('#TotalUsers').textContent = data.totalUsers; // Atualiza o contador de questões
        } catch (error) {
            console.error('Error fetching count:', error);
        }
    };

    // Função para criar a tabela de histórico
    const createHistoryTable = async () => {
        const historyTemplate = `
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Histórico recente</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Descrição</th>
                            <th>Data/Hora</th>
                            <th>Nível</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <tr>
                            <td colspan="4">Carregando...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>`;

        const historyContainer = document.createElement('div');
        historyContainer.innerHTML = historyTemplate;

        // Fetch de dados do histórico
        const tbody = historyContainer.querySelector('#historyTableBody');
        try {
            const response = await fetch('./actions/get_adms_history.php');
            const data = await response.json();
            tbody.innerHTML = '';
            if (data.length > 0) {
                // Limita a 3 últimos registros
                const recentHistory = data.slice(0, 3);
                recentHistory.forEach(history => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td><img src="${history.picture}"><p>${history.name}</p></td>
                    <td>${history.description}</td>
                    <td>${history.occurred_at}</td>
                    <td><span class="${history.importance}_importance">${history.importance}</span></td>`;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4">Nenhum registro encontrado</td></tr>';
            }
        } catch (error) {
            console.error('Erro:', error);
            tbody.innerHTML = '<tr><td colspan="4">Erro ao carregar os dados.</td></tr>';
        }

        return historyContainer;
    };

    const container = document.createElement('div');
    const template = `
    <div class="head-title">
        <div class="left">
            <h1>Painel</h1>
            <ul class="breadcrumb">
                <li><a>Painel</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active">Home</a></li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-layer'></i>
            <span class="text">
                <h3 id="TotalQuestions">0</h3>
                <p>Questões</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3 id="TotalUsers">0</h3>
                <p>Usuários Ativos</p>
            </span>
        </li>
    </ul>`;

    updateCounters();
    container.innerHTML = template;

    // Adiciona a tabela de histórico
    createHistoryTable().then(historyTable => {
        container.appendChild(historyTable);
    });

    return container;
};
