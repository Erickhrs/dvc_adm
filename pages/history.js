export default () => {
    const container = document.createElement('div');
    const template = `
    <div class="head-title">
        <div class="left">
            <h1>Histórico</h1>
            <ul class="breadcrumb">
                <li>
                    <a>Painel</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active">Histórico</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Lista de Usuários</h3>
                <div class="search-box" style="    display: flex;
    align-items: center;
    gap: 15px;">
                    <input style="width: 100%;"type="text" id="searchInput" placeholder="Pesquisar..." oninput="filterHistory()">
                    <i class="bx bx-search"></i>
                </div>
                <a onClick="confirmCleanHistory(event)" class="newUserBtn">
                    <i class='bx bx-brush-alt'></i>
                </a>
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
                <tbody id="TableBody">
                    <tr>
                        <td colspan="4">Carregando...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>`;

    container.innerHTML = template;

    // Função para buscar o histórico
    fetch('./actions/get_adms_history.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('TableBody');
            tbody.innerHTML = '';
            if (data.length > 0) {
                data.forEach(history => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><img src="${history.picture}"><p>${history.name}</p></td>
                        <td>${history.description}</td>
                        <td>${history.occurred_at}</td>
                        <td><span class="${history.importance}_importance">${history.importance}</td></span>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4">Nenhum registro encontrado</td></tr>';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            const tbody = document.getElementById('TableBody');
            tbody.innerHTML = '<tr><td colspan="4">Erro ao carregar os dados.</td></tr>';
        });

    // Função para limpar o histórico após confirmação
    window.confirmCleanHistory = (event) => {
        if (confirm('Você tem certeza que deseja limpar todo o histórico?')) {
            fetch('./actions/clear_adms_history.php', { method: 'POST' })
                .then(response => {
                    if (response.ok) {
                        alert('Histórico limpo com sucesso!');
                        document.getElementById('TableBody').innerHTML = '<tr><td colspan="4">Nenhum registro encontrado</td></tr>';
                    } else {
                        alert('Erro ao limpar o histórico.');
                    }
                })
                .catch(error => {
                    console.error('Erro ao limpar histórico:', error);
                    alert('Erro ao limpar o histórico.');
                });
        }
    };

    // Função para filtrar o histórico
    window.filterHistory = () => {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#TableBody tr');
        rows.forEach(row => {
            const columns = row.querySelectorAll('td');
            const match = Array.from(columns).some(column => column.innerText.toLowerCase().includes(input));
            row.style.display = match ? '' : 'none';
        });
    };

    return container;
};
