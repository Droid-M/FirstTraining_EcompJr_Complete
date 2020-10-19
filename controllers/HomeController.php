<?php 

/**
 * Entidade responsavel por apresentar as primeiras telas ao usuario
 * @author Marcos Vinicius F. dos Santos
 * @author EcompJr
 *
 */
class HomeController{
    
    /**
     * Leva para a tela de login
     */
    public function login(){
        header("Location:/Treinamento2020/views/login.php");
    }

    /**
     * Leva para a página inicial
     */
    public function index(){
        header("Location:/Treinamento2020/views/home.php");
    }
}
