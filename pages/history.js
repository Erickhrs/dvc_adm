export default () =>{
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
                        <a href="./newUser.php" class="newUserBtn"><i class="bx bx-user-plus"></i></a>
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
                         <tbody id="admsTableBody"><tr>
                    <td><img src="./uploads/userTeste.jpg"><p>Clóvis</p></td>
                    <td>2024-06-16</td>
                    <td class="ativo_status">ativo</td>
                    <td>undefined</td>
                    </tbody>
                    </table>
                </div>
            </div>
`

    container.innerHTML = template;
    return container;
}