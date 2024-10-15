export default () => {
    const container = document.createElement('div');
    const template = `
        <div class="head-title">
            <div class="left">
                <h1>Estatísticas</h1>
                <ul class="breadcrumb">
                    <li>
                        <a>Estatísticas</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active">Painel</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="charts-container">
            <!-- Gráfico de Novos Usuários -->
            <div class="chart-card">
                <div class="chart-label">Novos Usuários por Mês</div>
                <canvas id="userChart"></canvas>
            </div>

            <!-- Gráfico de Acertos e Erros -->
            <div class="chart-card">
                <div class="chart-label">Acertos vs Erros</div>
                <canvas id="accuracyChart"></canvas>
            </div>

            <!-- Gráfico de Questões Novas -->
            <div class="chart-card">
                <div class="chart-label">Questões Novas por Mês</div>
                <canvas id="questionsChart"></canvas>
            </div>

            <!-- Gráfico de Usuários por Plano -->
            <div class="chart-card">
                <div class="chart-label">Usuários por Plano</div>
                <canvas id="planChart"></canvas>
            </div>
            
            <!-- Gráfico de Interações dos Usuários -->
            <div class="chart-card">
                <div class="chart-label">Interações dos Usuários por Mês</div>
                <canvas id="interactionChart"></canvas>
            </div>

            <div class="chart-card">
    <div class="chart-label">Tipos de Questões</div>
    <canvas id="questionTypesChart"></canvas>
</div>

        </div>
        
        <style>
            .charts-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                padding-top: 50px;
            }

            .chart-card {
                width: 300px;
                height: 220px;
                padding: 10px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            .chart-card canvas {
                width: 100% !important;
                height: 180px !important;
            }

            .chart-label {
                text-align: center;
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 5px;
            }
        </style>
    `;

    container.innerHTML = template;

    let accuracyChartInstance = null; // Variável para armazenar a instância do gráfico de Acertos vs Erros
    let questionsChartInstance = null; // Variável para armazenar a instância do gráfico de Questões Novas
    let planChartInstance = null; // Variável para armazenar a instância do gráfico de Usuários por Plano
    let interactionChartInstance = null; // Variável para armazenar a instância do gráfico de Interações

    // Função para buscar os dados da API (Novos Usuários)
    async function fetchUserStats() {
        const response = await fetch('./actions/get_users_since.php');
        const data = await response.json();
        
        const months = data.map(item => item.month);
        const totals = data.map(item => item.total);
        
        const ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Novos Usuários',
                    data: totals,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                    barThickness: 20,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }

    // Função para buscar os dados de acertos e erros
    async function fetchAccuracyStats() {
        try {
            const response = await fetch('./actions/get_users_answers.php');
            const data = await response.json();

            const correct = data.filter(answer => answer.is_correct == 1).length;
            const incorrect = data.filter(answer => answer.is_correct == 0).length;

            if (accuracyChartInstance !== null) {
                accuracyChartInstance.destroy();
            }

            const ctx = document.getElementById('accuracyChart').getContext('2d');
            accuracyChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Acertos', 'Erros'],
                    datasets: [{
                        label: 'Acertos vs Erros',
                        data: [correct, incorrect],
                        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        } catch (error) {
            console.error("Erro ao carregar os dados de acertos vs erros:", error);
        }
    }

    // Função para buscar os dados de novas questões por mês
    async function fetchQuestionsStats() {
        try {
            const response = await fetch('./actions/get_questions_by_month.php');
            const data = await response.json();

            const months = data.map(item => item.month);
            const totals = data.map(item => item.total);

            if (questionsChartInstance !== null) {
                questionsChartInstance.destroy();
            }

            const ctx = document.getElementById('questionsChart').getContext('2d');
            questionsChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Questões Novas',
                        data: totals,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } catch (error) {
            console.error("Erro ao carregar os dados de questões novas:", error);
        }
    }

    // Função para buscar os dados de usuários por plano
    async function fetchPlanStats() {
        try {
            const response = await fetch('./actions/get_users_by_plan.php');
            const data = await response.json();

            const plans = ['Padrão', 'Pro', 'Avançado'];
            const totals = [0, 0, 0]; // Total para cada plano

            data.forEach(user => {
                if (user.plan === 0) totals[0]++;
                if (user.plan === 1) totals[1]++;
                if (user.plan === 2) totals[2]++;
            });

            if (planChartInstance !== null) {
                planChartInstance.destroy();
            }

            const ctx = document.getElementById('planChart').getContext('2d');
            planChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: plans,
                    datasets: [{
                        label: 'Usuários por Plano',
                        data: totals,
                        backgroundColor: ['rgba(255, 206, 86, 0.6)', 'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)'],
                        borderColor: ['rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                        borderWidth: 1,
                        borderRadius: 5,
                        barThickness: 20,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error("Erro ao carregar os dados de usuários por plano:", error);
        }
    }

    // Função para buscar os dados de interações dos usuários
    async function fetchInteractionStats() {
        try {
            const response = await fetch('./actions/get_user_interactions.php');
            const data = await response.json();

            const months = data.map(item => item.month);
            const commentTotals = data.map(item => item.comment_count);
            const feedbackTotals = data.map(item => item.feedback_count);
            
            if (interactionChartInstance !== null) {
                interactionChartInstance.destroy();
            }

            const ctx = document.getElementById('interactionChart').getContext('2d');
            interactionChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Comentários',
                            data: commentTotals,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            barThickness: 20,
                        },
                        {
                            label: 'Feedbacks',
                            data: feedbackTotals,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            barThickness: 20,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        } catch (error) {
            console.error("Erro ao carregar os dados de interações:", error);
        }
    }
// Função para buscar a contagem de questões do tipo mult e tf
async function fetchQuestionTypesStats() {
    try {
        const response = await fetch('./actions/get_question_types.php');
        const data = await response.json();

        const multCount = data.mult || 0; // Se não existir, assume 0
        const tfCount = data.tf || 0; // Se não existir, assume 0

        // Aqui você pode atualizar a interface ou um gráfico
        console.log(`Questões múltipla escolha (mult): ${multCount}`);
        console.log(`Questões verdadeiro ou falso (tf): ${tfCount}`);

        // Se você quiser exibir em um gráfico, aqui está um exemplo simples
        const ctx = document.getElementById('questionTypesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Múltipla Escolha', 'Verdadeiro ou Falso'],
                datasets: [{
                    label: 'Contagem de Questões',
                    data: [multCount, tfCount],
                    backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } catch (error) {
        console.error("Erro ao carregar os dados de contagem de questões:", error);
    }
}

    // Executar funções de busca de dados
    fetchUserStats();
    fetchAccuracyStats();
    fetchQuestionsStats();
    fetchPlanStats();
    fetchInteractionStats();
    fetchQuestionTypesStats();
    return container;
};
