<?php 
    require_once "../../../DB/Connection.php";
    require_once "../../../models/User.php";
    require_once "../../../controllers/UserController.php";
    UserController::verifyLogin();
    UserController::verifyAdmin();   
?>

<html>
    <head>
        <link rel="stylesheet" href="../../../css/style.css">
        <script>
            function passwordCheck() {
                password = document.create.password.value
                password_confirmation = document.create.password_confirmation.value

                if (password == password_confirmation) {
                    document.create.action = "/Treinamento2020/user/store"
                    document.create.submit()
                } else
                    alert("As senhas diferem!")
            }
         </script>
        <title>Cadastrar usuário</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div id="create_profile">
            <div class="col-md-12" class>
                    <h2 class="first-message">Cadrastro de usuário</h2>
            </div>
            <div class="row">
                <form onsubmit="passwordCheck()" name="create" enctype="multipart/form-data"  method="post">
                    <P>Nome: <input name="name" required></P>
                    <P>Email: <input type="email" name="email" required></P>
                    <P>Tipo de usuário: <select name="type" required></P>
                        <option value="" selected required>Selecione um tipo</option>
                        <option value="admin">Administrador</option>
                        <option value="user" >Usuário comum</option>
                    </select>
                    <P>Senha: <input type="password" placeholder="Insira uma senha" name="password" required>
                    <input type="password" placeholder="Confirme a senha" name="password_confirmation"required></P>
                    <P>Imagem de perfil: <input type="file" name="patchImage" accept="image"></P>
                    <button type="submit">Criar usuário</button>
                </form>
            </div>
            <div class="row">
                <a href="/Treinamento2020/views/users/dashboard.php">
                    <button type="">Cancelar</button>
                </a>
            </div>
        </div>
    </body>
</html>