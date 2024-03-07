<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tbody {
            border-right: outset;
        }
        #btnCreateUser {
            margin-bottom: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
    <h1>Usuários</h1>
    <button id="btnCreateUser">Adicionar novo cliente</button>
    <div id="userList">
        <!--listagem de usuários -->
    </div>
    <div id="createForm" style="display: none;">
        <form id="createUserForm">
        <label for="name">Nome:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="role">Função:</label><br>
        <select id="role" name="role">
            <option value="none">Selecionar</option>
            <option value="adm">Administrador</option>
            <option value="vendedor">Vendedor</option>
            <option value="cliente">Cliente</option>
        </select><br>
        <div id="cliente-fields" style="display: none;">
            <label for="cpf">CPF:</label><br>
            <input type="text" id="cpf" name="cpf"><br>
            <label for="date_of_birth">Data de Nascimento:</label><br>
            <input type="date" id="date_of_birth" name="date_of_birth"><br>
            <label for="street">Rua:</label><br>
            <input type="text" id="street" name="street"><br>
            <label for="house_number">Número da residência:</label><br>
            <input type="number" id="house_number" name="house_number"><br>
            <label for="street">Cidade:</label><br>
            <input type="text" id="city" name="city"><br>
            <label for="state">Estado:</label><br>
            <select id="state" name="state">
                <option value="none">Selecionar</option>
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
            </select><br>
            <label for="zip_code">CEP:</label><br>
            <input type="text" id="zip_code" name="zip_code"><br>

        </div>
        <div id="vendedor-adm-fields" style="display: none;">
            <label for="password">Senha:</label><br>
            <input type="password" id="password" name="password"><br>
        </div>
        <button type="submit">Criar usuário</button>
            </form>
        </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            loadUserList();
        });

        $(document).ready(function(){
            $('#cpf').mask('000.000.000-00', {reverse: true});
            $('#zip_code').mask('00000-000');
        });

        function loadUserList() {
            fetch('../backend/api/view_users.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const userList = document.getElementById("userList");
                    userList.innerHTML = "";
                    userList.innerHTML += `
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo de usuário</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    data.data.forEach(user => {
                        userList.querySelector('tbody').innerHTML += `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.role}</td>
                            </tr>
                        `;
                    });

                    userList.innerHTML += `
                            </tbody>
                        </table>
                    `;
                } else {
                    alert('Erro ao carregar a listagem de usuários: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro ao carregar a listagem de usuários:', error);
            });
        }

        document.getElementById("btnCreateUser").addEventListener("click", function() {
            document.getElementById("userList").style.display = "none";
            document.getElementById("createForm").style.display = "block";
            this.style.display = "none"; 
        });

        document.getElementById("role").addEventListener("change", function() {
            var selectedRole = this.value;
            var clienteFields = document.getElementById("cliente-fields");
            var vendedorAdmFields = document.getElementById("vendedor-adm-fields");

            clienteFields.style.display = selectedRole === "cliente" ? "block" : "none";
            vendedorAdmFields.style.display = (selectedRole === "vendedor" || selectedRole === "adm") ? "block" : "none";

            window.addEventListener("load", function() {
                var selectedRole = document.getElementById("role").value;
                var clienteFields = document.getElementById("cliente-fields");

                if (selectedRole !== "cliente") {
                    document.getElementById("cpf").value = "";
                    document.getElementById("date_of_birth").value = "";
                    document.getElementById("street").value = "";
                    document.getElementById("house_number").value = "";
                    document.getElementById("city").value = "";
                    document.getElementById("street").value = "";
                    document.getElementById("zip_code").value = "";
                }
            });

        document.getElementById("createUserForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            const selectedRole = document.getElementById("role").value;
            if (selectedRole === "cliente") {
                // Adicione os campos específicos para clientes
                formData.append("cpf", document.getElementById("cpf").value);
                formData.append("date_of_birth", document.getElementById("date_of_birth").value);
                formData.append("street", document.getElementById("street").value);
                formData.append("house_number", document.getElementById("house_number").value);
                formData.append("city", document.getElementById("city").value);
                formData.append("state", document.getElementById("state").value);
                formData.append("zip_code", document.getElementById("zip_code").value);
            }

            fetch('../backend/api/create_users.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("name").value = "";
                    document.getElementById("email").value = "";
                    document.getElementById("password").value = "";
                    document.getElementById("cpf").value = "";
                    document.getElementById("date_of_birth").value = "";
                    document.getElementById("street").value = "";
                    document.getElementById("house_number").value = "";
                    document.getElementById("city").value = "";
                    document.getElementById("state").value = "";
                    document.getElementById("zip_code").value = "";

                    alert('Usuário criado com sucesso');

                    setTimeout(function() {
                        document.getElementById("userList").style.display = "block";
                        document.getElementById("createForm").style.display = "none";
                        document.getElementById("btnCreateUser").style.display = "block";
                        
                        loadUserList();
                    }, 1000); 
                } else {
                    alert('Erro ao criar usuário: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro ao criar usuário:', error);
            });
        });


        });
    </script>
</body>
</html>
