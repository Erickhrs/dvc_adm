export default () => {

    const updateCounters = async () => {
        try {
            const response = await fetch('./actions/counts.php');
            const data = await response.json();
            document.querySelector('#ActAdms').textContent = data.totalAdmAct;
            document.querySelector('#DesAdms').textContent = data.totalAdmDes;  // Atualiza o contador de questões
        } catch (error) {
            console.error('Error fetching count:', error);
        }
    };
    const container = document.createElement('div');
    const template = `
    <div class="head-title">
        <div class="left">
            <h1>Usuários</h1>
            <ul class="breadcrumb">
              <li>
                            <a >Painel</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a href="#users">Usuários</a>
                        </li><i class='bx bx-chevron-right'></i></li>
                          <li>
                            <a class="active" href="#adms">Administradores</a>
                        </li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3 id="ActAdms">0</h3>
                <p>Adms ativos</p>
            </span>
        </li>
        <li>
            <i class='bx bx-user-x' style="background: var(--light-orange);color: var(--orange);"></i>
            <span class="text">
                <h3 id="DesAdms">0</h3>
                <p>Adms Desativados</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Lista de Usuários</h3>
                <i class='bx bx-search'></i>
                <i class='bx bx-filter'></i>
                 <a href="./newAdm.php" class="newUserBtn"><i class='bx bx-user-plus' ></i></a>
            </div>
            <div class="userType">
                <a href="#users" id="usersOption"><i
                        class='bx bxs-user'></i></i>Assinantes</a>
                <a href="#adms" id="admsOption" class="userType-active"><i class='bx bx-briefcase'></i>Adms</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Desde</th>
                        <th>Status</th>
                        <th>Plano</th>
                    </tr>
                </thead>
                <tbody id="admsTableBody">
                    <tr>
                        <td colspan="4">Carregando...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    `;
    container.innerHTML = template;
    document.body.appendChild(container);
    fetch('./actions/get_adms.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('admsTableBody');
            tbody.innerHTML = '';
            if (data.length > 0) {
                data.forEach(user => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><img src="${user.picture}"><p>${user.name}</p></td>
                        <td>${user.since}</td>
                        <td class="${user.status}_status">${user.status}</td>
                        <td><span class="${user.roles_id}_cargo">${user.roles_id}</span></td>
                         <td>
                            <form action="./admProfile.php" method="post">
                                    <input type="hidden" name="id_adm" value="${user.ID}">
                                    <input type="hidden" name="name_adm" value="${user.name}">
                                    <input type="hidden" name="email_adm" value="${user.email}">
                                    <input type="hidden" name="uf_adm" value="${user.UF}">
                                    <input type="hidden" name="picture_adm" value="${user.picture}">
                                    <input type="hidden" name="since_adm" value="${user.since}">
                                    <input type="hidden" name="status_adm" value="${user.status}">
                                    <input type="hidden" name="role_adm" value="${user.roles_id}">
                                <button type="submit" class="bx bx-show viewIcon" name="formButton"></button>
                            </form>
                        </td>
                         <td>
                              <form action="./admProfileEdit.php" method="post">
                                 <input type="hidden" name="id_adm" value="${user.ID}">
                                    <input type="hidden" name="name_adm" value="${user.name}">
                                    <input type="hidden" name="email_adm" value="${user.email}">
                                    <input type="hidden" name="uf_adm" value="${user.UF}">
                                    <input type="hidden" name="picture_adm" value="${user.picture}">
                                    <input type="hidden" name="since_adm" value="${user.since}">
                                    <input type="hidden" name="status_adm" value="${user.status}">
                                    <input type="hidden" name="role_adm" value="${user.roles_id}">
                                <button type="submit" class="bx bx-edit editIcon" name="formButton"></button>
                                </form>
                         </td>
                         <td>
                             <form action="./actions/deletingUserConfirm.php" method="post">
                                    <input type="hidden" name="email_user" value="${user.email}">
                                    <input type="hidden" name="userType" value="adm">
                                    <input type="hidden" name="picture_user" value="${user.picture}">
                                    <input type="hidden" name="name_user" value="${user.name}">
                                    <input type="hidden" name="id_user" value="${user.ID}">
                                  <button type="submit" class="bx bx-trash" name="formButton" style="border: none; cursor:pointer"></button>
                            </form>
                            </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4">Nenhum usuário encontrado.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            const tbody = document.getElementById('admsTableBody');
            tbody.innerHTML = '<tr><td colspan="4">Erro ao carregar os dados.</td></tr>';
        });

    updateCounters();
    return container;
}
