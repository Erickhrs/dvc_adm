export default () => {
    const container = document.createElement('div');
    const template = `
     <div class="head-title">
                <div class="left">
                    <h1>Usuários</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Painel</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a href="#users">Usuários</a>
                        </li><i class='bx bx-chevron-right'></i></li>
                          <li>
                            <a class="active" href="#users">Assinantes</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3>0</h3>
                        <p>Usuários ativos</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-user-check'></i>
                    <span class="text">
                        <h3>0</h3>
                        <p>Usuários Assinantes</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-user-x'></i>
                    <span class="text">
                        <h3>0</h3>
                        <p>Usuários Desativados</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Lista de Usuários</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <div class="userType">
                        <a href="#users" id="usersOption" class="userType-active"><i
                                class='bx bxs-user'></i></i>Assinantes</a>
                        <a href="#adms" id="admsOption"><i class='bx bx-briefcase'></i>Adms</a>
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
    `
    fetch('./actions/get_users.php')
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
                    <td>${user.roles_id}</td>
                     <td>
                            <form action="./userProfile.php" method="post">
                                    <input type="hidden" name="id_user" value="${user.ID}">
                                    <input type="hidden" name="name_user" value="${user.name}">
                                    <input type="hidden" name="email_user" value="${user.email}">
                                    <input type="hidden" name="phone_user" value="${user.phone}">
                                    <input type="hidden" name="cpf_user" value="${user.CPF}">
                                    <input type="hidden" name="cnpj_user" value="${user.CNPJ}">
                                    <input type="hidden" name="address_user" value="${user.address}">
                                    <input type="hidden" name="district_user" value="${user.district}">
                                    <input type="hidden" name="city_user" value="${user.city}">
                                    <input type="hidden" name="uf_user" value="${user.UF}">
                                     <input type="hidden" name="cep_user" value="${user.CEP}">
                                    <input type="hidden" name="picture_user" value="${user.picture}">
                                     <input type="hidden" name="birth_user" value="${user.birth}">
                                    <input type="hidden" name="since_user" value="${user.since}">
                                    <input type="hidden" name="status_user" value="${user.status}">
                                <button type="submit" class="bx bx-show viewIcon" name="formButton"></button>
                            </form>
                        </td>
                        <td>
                          <form action="./userProfileEdit.php" method="post">
                                    <input type="hidden" name="id_user" value="${user.ID}">
                                    <input type="hidden" name="name_user" value="${user.name}">
                                    <input type="hidden" name="email_user" value="${user.email}">
                                    <input type="hidden" name="phone_user" value="${user.phone}">
                                    <input type="hidden" name="cpf_user" value="${user.CPF}">
                                    <input type="hidden" name="cnpj_user" value="${user.CNPJ}">
                                    <input type="hidden" name="address_user" value="${user.address}">
                                    <input type="hidden" name="district_user" value="${user.district}">
                                    <input type="hidden" name="city_user" value="${user.city}">
                                    <input type="hidden" name="uf_user" value="${user.UF}">
                                     <input type="hidden" name="cep_user" value="${user.CEP}">
                                    <input type="hidden" name="picture_user" value="${user.picture}">
                                     <input type="hidden" name="birth_user" value="${user.birth}">
                                    <input type="hidden" name="since_user" value="${user.since}">
                                    <input type="hidden" name="status_user" value="${user.status}">
                                  <button type="submit" class="bx bx-edit editIcon" name="formButton"></button>
                            </form>
                            </td>
        `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4">Nenhum usuário encontrado.</td></tr>';
            }
        }).catch(error => {
            console.error('Erro:', error);
            const tbody = document.getElementById('admsTableBody');
            tbody.innerHTML = '<tr><td colspan="4">Erro ao carregar os dados.</td></tr>';
        });

    container.innerHTML = template;
    return container;
}