export default () =>{
    const container = document.createElement('div');
    const template = `<div class="head-title">
    <div class="left">
        <h1>Gerenciador de Questões</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Painel</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Home</a>
            </li>
        </ul>
    </div>
</div>
<div class="table-data">
                <div class="order" style="padding:0px!important;background-color:transparent!important;">
                    <div class="head" style="margin-bottom:0px!important">
                        <a href="./newQuestion.php" class="newQuestionBtn"><i class='bx bx-plus'></i>Nova questão</a>
                        <a href="./disciplines.php" class="newQuestionBtn"><i class='bx bx-plus'></i>Novo atributo<a>
                    </div>
                   
                </div>
            </div>

<form action="" method="get">
    <div id="filter1">
        <input type="search" placeholder="Palavra chave">
        <select id="discipline" name="discipline">
            <option value="">Disciplinas</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="subjects" name="">
            <option value="">Assunto</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="banca" name="">
            <option value="">Banca</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="institution" name="institution">
            <option value="">Instituto</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="year" name="year">
            <option value="">Ano</option>
            <option value="">2004</option>
            <option value="">2005</option>
        </select>
        <select id="job_position" name="job_position">
            <option value="">Cargo</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="grade_level" name="grade_level">
            <option value="">Nível</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="course" name="course">
            <option value="">Formação</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="area_of_expertise" name="area_of_expertise">
            <option value="">Atuação</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="question_type" name="question_type">
            <option value="">Modalidade</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
        <select id="level" name="level">
            <option value="">Dificuldadee</option>
            <option value="">EXEMPLO 1</option>
            <option value="">EXEMPLO 2</option>
        </select>
    </div>
    <div id="filter2">
        <span>Excluir Questões:</span>
        <label for="opcao1">
            <input type="checkbox" name="opcoes" value="opcao1"> Dos meus cadernos
        </label>
        <label for="opcao2">
            <input type="checkbox" name="opcoes" value="opcao2"> Dos meus Simulados
        </label><br><br>
        <span>Questões com:</span>
        <label for="opcao3">
            <input type="checkbox" name="opcoes" value="opcao3"> Gabarito comentado
        </label>
        <label for="opcao4">
            <input type="checkbox" name="opcoes" value="opcao4"> Comentários
        </label>
        <label for="opcao5">
            <input type="checkbox" name="opcoes" value="opcao5"> Meus Comentários
        </label>
        <label for="opcao6">
            <input type="checkbox" name="opcoes" value="opcao6"> Aulas
        </label>
        <label for="opcao7">
            <input type="checkbox" name="opcoes" value="opcao7"> Minhas anotações
        </label>
    </div>
    <div id="btns">
        <button><ion-icon name="reload-outline"></ion-icon> Limpar</button>
        <input type="submit" value="FILTRAR">
    </div>
</form>

<ul class="box-info">
<li>
<i class='bx bxs-layer'></i>
<span class="text">
    <h3>0</h3>
    <p>Questões ativas</p>
</span>
</li>
<li>
<i class='bx bxs-file-find' ></i>
<span class="text">
    <h3>0</h3>
    <p>Questões encontradas</p>
</span>
</li>
</ul>
<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Resultados</h3>
            <i class='bx bx-search'></i>
            <i class='bx bx-filter'></i>
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
                  <td colspan="4">Carregando...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<style>
    #root form {
        background-color: var(--logo-blue);
        padding: 20px 100px 20px 100px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        margin-top: 15px;
        border-radius: 15px;
    }

    form #filter1 select {
        width: 150px;
        height: 45px;
        padding: 10px 10px 10px 10px;
        margin-right: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        border: none;
    }

    form #filter1 input {
        width: 150px;
        height: 45px;
        padding: 0px 10px 0px 10px;
        margin-right: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        border: none;
    }

    form #filter2 {
        padding: 20px 0px 20px 0px;
    }

    form #filter2 span {
        color: var(--green-todbg);
        font-weight: bold;
        padding-right: 40px;
    }

    form #filter2 label {
        color: white;
        padding-right: 40px;
    }

    form input:only-of-type[type="submit"] {
        color: white;
        background-color: var(--main-color);
        padding: 8px 20px 8px 20px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    form button {
        color: white;
        background-color: var(--main-color);
        padding: 8px 20px 8px 20px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        margin-right: 10px;
    }

    #root header {
        text-align: center;
        justify-content: center;
        flex-direction: column;
        border: none;
        padding-bottom: 30px;
        border-top: 1px solid rgba(128, 128, 128, 0.2);
        border-bottom: 1px solid rgb(153, 152, 152);
    }

    #root header #filterDetails {
        color: var(--logo-green);
        padding: 0px;
        margin: 0px;
        font-size: 10px;
        font-weight: 600;
    }

    #root header h1 {
        font-weight: 500;
        padding: 10px;
        margin: 0px;
    }
</style>
`
fetch('./actions/get_questions.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('questionTB');
            tbody.innerHTML = '';
            if (data.length > 0) {
                data.forEach(data => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td class="questionTD"><p style="width: fit-content;text-align: left; height: 100px;overflow-y: auto;max-width">${data.question}</p></td>
                    <td>${data.correct}</td>
                    <td>${data.adms_id}</td>
                    <td>${data.created_at}</td>
                     <td class='${data.status}_status'>${data.status}</td>
        `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4">Nenhuma questão encontrada.</td></tr>';
            }
        }).catch(error => {
            console.error('Erro:', error);
            const tbody = document.getElementById('admsTableBody');
            tbody.innerHTML = '<tr><td colspan="4">Erro ao carregar os dados.</td></tr>';
        });


    container.innerHTML = template;
    return container;
}