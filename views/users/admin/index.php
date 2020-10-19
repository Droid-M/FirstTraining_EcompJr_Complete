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
        <title>Index</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div id="index">
            <div class="col-md-12" class>
                <h2 class="first-message">Lista de usuários</h2>
            </div>
            <div class="row">
                    <a href="/Treinamento2020/views/users/dashboard.php">
                        <button>
                            Acessar painel de controle
                        </button>
                    </a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Senha</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $users = UserController::all();
                            foreach($users as $user) {
                        ?>
                                <tr>
                                    <td><img src="<?=$user->getPatchProfileImg()."?".date('d/m/Y H:i:s')?>" alt="some text" width=50 height=40></td>
                                    <td><?=$user->getName()?></td>
                                    <td><?=$user->getEmail()?></td>
                                    <td><?=$user->getType()?></td>
                        <?php
                                    if($user->getId() != $_SESSION['user']->getId()) {
                        ?>
                                        <td>
                                            <a href="/Treinamento2020/user/edit/<?php echo $user->getId()?>">
                                                <button>
                                                    editar
                                                </button>
                                            </a>
                                            <a href="/Treinamento2020/user/delete/<?php echo $user->getId()?>">
                                                <button>
                                                    excluir
                                                </button>
                                            </a>
                                        </td>
                        <?php
                                    } else {
                        ?> 
                                        <td>
                                            <a href="/Treinamento2020/user/profile">
                                                <button>
                                                    Meu perfil
                                                </button>
                                            </a>
                                        </td>
                                </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>