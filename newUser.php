<?php
include('./includes/protect.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="./styles/newUser.css">
    <link rel="stylesheet" href="./styles/global.css">
</head>

<body>
    <div class="container">
        <h1>Cadastro de Usuário</h1>
        <img src="./assets/logo.png" alt="logo" id="logo">
        <form method="post" action="./actions/in_newUser.php" enctype="multipart/form-data">
            <div class="section">
                <h2>Informações Pessoais</h2>
                <div class="form-group">
                    <label for="name"> Nome</label>
                    <input type="text" id="name" name="name" maxlength="50" minlength="5" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" maxlength="100" minlength="10" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" id="phone" name="phone" maxlength="25" minlength="11" required>
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" maxlength="11" minlength="11" required>
                </div>
                <div class="form-group">
                    <label for="birth">Data de Nascimento</label>
                    <input type="date" id="birth" name="birth" required>
                </div>
                <div class="form-group">
                    <label for="picture">Foto</label>
                    <input type="file" id="picture" name="picture" required accept="image/*">
                </div>
            </div>
            <div class="section">
                <h2>Endereço</h2>
                <div class="form-group">
                    <label for="address">Endereço</label>
                    <input type="text" id="address" name="address" maxlength="150" required>
                </div>
                <div class="form-group">
                    <label for="district">Bairro</label>
                    <input type="text" id="district" name="district" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label for="city">Cidade</label>
                    <input type="text" id="city" name="city" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label for="uf">UF</label>
                    <select id="uf" name="uf" required>
                        <option value="">Selecione um Estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cep" required>CEP</label>
                    <input type="text" id="cep" name="cep" maxlength="8" minlength="8">
                </div>
            </div>
            <div class="section">
                <h2>Outras Informações</h2>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status">
                        <option value="1">Ativo</option>
                        <option value="0">Desativo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="since">Desde</label>
                    <input type="text" id="since" name="since" value="<?php echo date('d-m-Y')?>" disabled>
                </div>
                <div class="form-group" required>
                    <label for="password">Senha</label>
                    <input type="text" id="password" name="psw" value="dvc2024" disabled>
                </div>
            </div>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>

</html>