<?php 
    require_once "../../../DB/Connection.php";
    require_once "../../../models/User.php";
    require_once "../../../controllers/UserController.php";

    UserController::verifyLogin();
    UserController::verifyAdmin();
    $user = UserController::get($_GET['id']);
?>

<html>
    <head>
        <link rel="stylesheet" href="../../../css/style.css">
        <script>
            function passwordCheck() {
                password = edit.password.value
                password_confirmation = edit.password_confirmation.value
                edit.action = "/Treinamento2020/user/update/<?php echo $user->getId()?>"
                if (password != password_confirmation) {
                    edit.action = ""
                    alert("As senhas diferem!")
                }
            }
        </script>
        <title>Editar perfil</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div id="create_profile">
            <div class="col-md-12" class>
                    <h2 class="first-message" style="margin-bottom: 70px;">Alteração de perfil</h2>
            </div>
            <form onsubmit="passwordCheck()" name="edit" enctype="multipart/form-data"  method="post">
                <div class="row">
                    <div class="col-md-5">
                        <div style="text-align: center;">
                            <P>Imagem de perfil atual: <br> <img type="image" src="<?=$user->getPatchProfileImg()."?".date('d/m/Y H:i:s')?>" width=300 height=430></P>
                        </div>    
                        <P>Nome: <input name="name" placeholder="name" value="<?php echo $user->getName()?>" required="required"></P>
                        <P>Email: <input type="email" name="email" placeholder="email" value="<?php echo $user->getEmail()?>" required></P>
                        <P>Tipo de usuário: <select name="type" required></P>
                            <option value="" unselected>Selecione um tipo</option>
                            <option value="admin"<?php if($user->getType() == "admin"){?> selected <?php }?>>Administrador</option>
                            <option value="user" <?php if($user->getType() == "user"){?> selected <?php }?>>Usuário comum</option>
                            </select>
                        <P>Senha: <input type="password" placeholder="Insira uma senha" name="password" required>
                        <input type="password" placeholder="Confirme a senha" name="password_confirmation"required></P>
                        <P><input type="checkbox" name="substImgPrfl" value="yes">Desejo substituir esta imagem de perfil<P>
                        <P>Escolher imagem:<input type="file" name="patchImage" value="<?=$user->getPatchProfileImg()?>" accept="image"></P>
                        <div style="text-align: center;">
                            <button type="submit">Atualizar dados</button>
                        </div>
                    </div> 
                    <div class="col-md-7" id="image-back-profile"></div>
                </div>
            </form>
            <a href="/Treinamento2020/views/users/dashboard.php">
                <div class="col-md-5" style="padding-left: 17%;">
                    <button>Cancelar</button>
                </div>
            </a>
        </div>
    </body>
</html>