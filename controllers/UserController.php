<?php 

UserController::setSession();

/**
 * Entidade responsavel por retransmitir informa��es entre classes da view e do model
 * @author Marcos Vinicius F. dos Santos
 * @author EcompJr
 * @access public
 */
class UserController{

    /**
     * Leva para a pagina de listagem de usuarios
     * @access public
     */
    public function index(){
        header("Location:/Treinamento2020/views/users/admin/index.php");
    }

    /**
     * Leva para a pagina de criacao de usuario
     * @access public
     */
    public function create(){
        header("Location:/Treinamento2020/views/users/admin/create.php");
    }

    /**
     * Leva para a pagina de armazanamento de usuario
     * @access public
     */
    public function store() {
        //Verificacao necessaria para evitar algum erro de indice:
        if( isset(
            $_POST['name'],
            $_POST['email'],
            $_POST['type'],
            $_POST['password'],
            $_POST['password_confirmation'] )) {
                User::create(
                $_POST['name'],
                $_POST['email'],
                $_POST['type'],
                $_POST['password'],
                $_POST['password_confirmation'],
                $_FILES['patchImage']['tmp_name'] );
        }
        header("Location:/Treinamento2020/views/users/dashboard.php");
    }

    /**
     * Leva para a pagina de edicao de dados de um outro usuario
     * @param string $id
     * @access public
     */
    public function edit($id){
        header("Location:/Treinamento2020/views/users/admin/edit.php?id={$id[0]}");
    }

    /**
     * Leva para a pagina de edicao de dados cadastrais do usuario
     * @access public
     */
    public function profile() {
        header("Location:/Treinamento2020/views/users/admin/profile.php");
    }

    /**
     * Trasfere os dados de usario para que a classe 'User' no model possa trata-los
     * @param string $id Idenficacao do usuario
     * @access public
     * @see /Treinamento/models/User.php
     */
    public function update($id) {
        self::verifyLogin();
        $id = $id[0]; /*O parametro 'id' na verdade eh um vetor contendo os dados da url para essa 
        classe e meto (incluindo o valor de 'id' no final)*/

        //Verificacao necessaria para evitar algum erro de indice:
        if($this->get($id) and isset(
            $_POST['name'],
            $_POST['email'],
            $_POST['type'],
            $_POST['password'],
            $_POST['password_confirmation'])) {
                $patchImgPrfl = isset($_POST['substImgPrfl']) ? $_FILES['patchImage']['tmp_name'] : "default";
                User::update(
                $id,$_POST['name'],
                $_POST['email'],
                $_POST['type'],
                $_POST['password'],
                $_POST['password_confirmation'],
                $patchImgPrfl);
                if($_SESSION['user']->getId() == $id) {
                    $_SESSION['user'] = User::get($id);
                }
                header("Location:/Treinamento2020/views/users/dashboard.php");
        }
        else {
            header("Location:/Treinamento2020/views/home.php");
        }
    }

    /**
     * Comunica ao model que os dados de determinado usuario devem ser removidos
     * @param string $id Idenficacao do usuario cujos dados serao removidos
     * @acess public
     */
    public function delete($id){
        User::delete($id[0]);
        header("Location:/Treinamento2020/views/users/dashboard.php");
    }

    /**
     * Fornece a 'view' os dados de todos os usuarios cadastrados
     * @return unknown Retorna o dado de todos os usuarios cadastrados
     * @access public
     * @see /Treinamento2020/views/users/admin/Index.php
     */
    public static function all(){
        return User::all();
    }
    
    /**
     * Consulta a classe 'User' para validar o email e senha de um usuario e permitir seu login
     * @access public
     * @see /Treinamento2020/models/User.php
     */
    public function check(){
        $userLogged = user::find($_POST['email'], $_POST['password']);
        if ($userLogged) {
            $_SESSION['user'] = $userLogged;
            header("Location:/Treinamento2020/views/users/dashboard.php");
        }
        else{
            header("Location:/Treinamento2020/views/login.php");
        }
    }

    /**
     * Verifica se o usuario esta logado no sistema, permitindo, em caso positivo, sua presenca na pagina
     * @access public
     */
    public static function verifyLogin() {
        if(empty($_SESSION)) {
            header("Location:/Treinamento2020/views/home.php");
        }
    }
    
    /**
     * Verifica se o usuario logado eh um administrador, permitindo, em caso positivo, sua presenca na pagina
     * @access public
     */
    public static function verifyAdmin() {
        if($_SESSION['user']->getType() != "admin") {
            header("Location:/Treinamento2020/views/home.php");
        }
    }

    /**
     * Realiza o logout de usuario e retorna a pagina inicial
     * @access public
     */
    public static function logout() {
        self::dropSession();
        header("Location:/Treinamento2020/views/home.php");
    }

    /**
     * Consulta a classe 'User' para retornar uma instancia dela contendo os dados de um usuario
     * @param string $id Idenficacao de usuario 
     * @return User|False Retorna o conjunto de dados do usuario se encontra-lo no sistema ou retorna
     * false caso contrario 
     * @see /Treinamento2020/models/User.php
     * @access public
     */
    public static function get($id){
        return User::get($id);
    }

    /**
     * Verifica se a sessao esta iniciada e a inicia caso nao esteja
     * @access public
     */
    public static function setSession() {
        if(!isset($_SESSION)) {
            session_start(); 
        }
    }

    /**
     * Encerra a sessao
     * @access public
     */
    public static function dropSession() {
        if(isset($_SESSION))
            session_unset();
    }
}
