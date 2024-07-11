export default () => {
    const container = document.createElement('div');
    const template = `<div class="head-title">
    <div class="left">
        <h1>Histórico</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Painel</a>
            </li>
            <li><i class='bx bx-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Home</a>
            </li>
        </ul>
    </div>
</div>


<div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Lista de Usuários</h3>
                        <i class="bx bx-search"></i>
                        <i class="bx bx-filter"></i>
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
            </div>
`
    fetch('./actions/get_adms_history.php').then(response => response.json()).then(data => {
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
    }).catch(error => {
        console.error('erro:', error)
        const tbody = document.getElementById('admsTableBody');
        tbody.innerHTML = '<tr><td colspan="4">Erro ao carregar os dados.</td></tr>';
    })


    container.innerHTML = template;
    return container;
}