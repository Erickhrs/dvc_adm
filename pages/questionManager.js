export default () => {
    const updateCounters = async () => {
        try {
            const response = await fetch('./actions/counts.php');
            const data = await response.json();
            document.querySelector('#TotalQuestions').textContent = data.totalQuestions;
            //document.querySelector('.box-info li:nth-child(2) h3').textContent = data.totalUsers;  // Atualiza o contador de questões
        } catch (error) {
            console.error('Error fetching count:', error);
        }
    };
    const container = document.createElement('div');
    const template = `<div class="head-title">
    <div class="left">
        <h1>Gerenciador de Questões</h1>
        <ul class="breadcrumb">
            <li>
                <a >Gerenciador Questões</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" >Painel</a>
            </li>
        </ul>
    </div>
</div>
<div class="table-data">
                <div class="order" style="padding:0px!important;background-color:transparent!important;">
                    <div class="head" style="margin-bottom:0px!important">
                        <a href="./newQuestion.php" class="newQuestionBtn"><i class='bx bx-plus'></i>Nova questão</a>
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
                    <td class="questionTD"><p style="width: fit-content;text-align: left;overflow-y: auto;max-width">${data.question}</p></td>
                    <td>${data.answer}</td>
                    <td>${data.adms_id}</td>
                    <td>${data.created_at}</td>
                     <td class='${data.status}_status'>${data.status}</td>

                     
        `;
                    tr.querySelector('.questionTD').addEventListener('click', () => {
                        window.location.href = `./question.php?id=${data.ID}`; // Substitua 'sua_pagina.html' pelo nome da sua página
                    });

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
    updateCounters();
    return container;
}