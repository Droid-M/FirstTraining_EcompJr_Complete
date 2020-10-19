<?php 
    require_once "../../DB/Connection.php";
    require_once "../../models/User.php";
    require_once "../../controllers/UserController.php";
    
    UserController::verifyLogin();
    UserController::setSession();
?>
<html>
    <head>
        <link rel="stylesheet" href="../../css/style.css">
        <title>Dashboard</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <Body>
        <div id="dashboard">
                <div class="col-md-12" class>
                    <h2 class="first-message"><?="Olá ".$_SESSION['user']->getName()."!"?></h2>
                </div>
            <div class="row">
                <div class="container-img">
                    <img src="<?=$_SESSION['user']->getPatchProfileImg()."?".date('d/m/Y H:i:s')?>" alt="imagem de perfil" width=300 height=430>
                </div>
                <br>
                <div class="col-md-12" style="text-align: center; margin-left: 40px; margin-top: -116px;">
                    <?php
                        if($_SESSION['user']->getType() == 'admin'){
                    ?>
                        <a href="/Treinamento2020/user/index">Listagem de usuários</a>
                        <a href="/Treinamento2020/user/create">Cadastrar novo usuário</a>
                    <?php
                        }
                    ?>
                    <a href="/Treinamento2020/user/profile">Meu Perfil</a>
                </div>
                <br>
                <br>
                <div class="linkage" style="margin-top: -30px; margin-right: 220px; margin-left: auto;">
                    <a href="/Treinamento2020/user/logout" style="color: green;">Sair</a>
                </div>
            </div>
        </div>
    </Body>
</html>