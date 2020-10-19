<?php
require_once "../controllers/UserController.php";
    
UserController::setSession(); 
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div class="row" class="a">
            <div class="col-md-12" id="screen-login">
                <form action="/Treinamento2020/user/check" method="post">
                    <div class="text-input">Email: </div> <input type="email" name="email" value="" placeholder="Insira seu email aqui" required>      
                    <div class="text-input">Senha: </div> <input name="password" type="password" placeholder="Insira sua senha aqui" required>
                    <br><button type="submit" class="submit-button"> Entrar </button>
                </form>
            </div>
        </div>
    </body>
</html>