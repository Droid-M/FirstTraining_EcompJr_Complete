<?php

define("imgExtension", ".extensaoQualquer");

/**
 * Entidade responsavel por alterar dados contidos no banco de dados
 * @author Marcos Vinicius F. dos Santos
 * @author EcompJr
 * @access public
 *
 */
class User{
    private $id;
    private $name;
    private $email;
    private $type;
    private $password;
    private $patchProfileImg;

    /**
     * Contrutor da classe
     * @param string $id Identificador de usuario
     * @param string $name Nome de usuario
     * @param string $email Email de usuario
     * @param string $type Tipo de usuario (admin ou normal)
     * @param string $patchProfileImg Caminho para a imagem de perfil de usuario
     * @access public
     */
    public function __construct($id, $name, $email, $type, $patchProfileImg) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $this->patchProfileImg = $patchProfileImg;
    }

    /**
     * Procura um usuario no banco de dados atraves do email e da senha
     * @param string $email Email do usuario
     * @param string $password Senha do usuario
     * @return User|boolean Retorna uma instancia de User caso encontre o usuario, senao, retorna false
     * @see User 
     * @access public
     */
    public static function find($email, $password) {
        $result = mysqli_query(Connection::getConnection(), "Select * from users where email = '{$email}' and password = '{$password}'");
        if(mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            return new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['type'],
                $user['patchImage']);
        }
        return false;
    }

    /**
     * Retorna uma instancia de User caso haja algum usuario no banco de dados contendo o id informado
     * @param string $id Identificacao do usuario procurado
     * @return User|boolean Retorna uma instancia de User contendo os dados do usuario encontrado
     * ou retorna false caso contrario
     * @access public
     * 
     */
    public static function get($id){
        $result = mysqli_query(Connection::getConnection(), "Select * from users where id = '{$id}'");
        if(mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            return new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['type'],
                $user['patchImage']);
        }
        return false;
    }

    /**
     * Armazena dados de um novo usuario no banco de dados
     * @param string $name Nome do usuario 
     * @param string  $email Email do usuario
     * @param string  $type  Tipo de usuario
     * @param string  $password Senha de usuario
     * @param string $password_confirmation Confirmacao de senha do usuario
     * @param string  $patchImage Caminho contendo a imagem de perfil do usuario
     * @access public
     */
    public static function create( $name, $email, $type, $password, $password_confirmation, $patchImage ) {
        if ($password == $password_confirmation)
            if (!self::find($email, $password)) {
                $newIdGener = self::getIdNewbieUser();
                $newPatchImg = USer::copyImage($patchImage, $newIdGener);
                mysqli_query(Connection::getConnection(), "Insert into users values (default,
                    '{$name}',
                    '{$email}',
                    '{$password}',
                    '{$type}',
                    '{$newPatchImg}')");
            }
    }

    /**
     * Retorna Dados de todos os usuarios cadastrados no banco de dados
     * @return User[] Vetor cujas posicoes contem o dado de um usuario
     * @access public  
     */
    public static function all() {
        $result = mysqli_query( Connection::getConnection(), "Select * from users" );
        $nRows= mysqli_num_rows($result);
        $users=[];
        for($i=0; $i < $nRows; $i++) {
            $user = mysqli_fetch_assoc($result);
            $users[$i] = new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['type'],
                $user['patchImage']);
        }
        return $users;
    }

    /**
     * Remove os dados de um usuario do banco de dados
     * @param string $id Identificacao do usuario cujos dados serao removidos
     * @access public
     */
    public static function delete($id){
        self::deleteImgProfile($id);
        mysqli_query(Connection::getConnection(), "Delete from users where id = '{$id}'");
    }

    /**
     * Atualiza os dados de um usuario
     * @param string $id Identificacao do usuario
     * @param string $name Nome do usuario 
     * @param string  $email Email do usuario
     * @param string  $type  Tipo de usuario
     * @param string  $password Senha de usuario
     * @param string $password_confirmation Confirmacao de senha do usuario
     * @param string  $patchImage Caminho contendo a imagem de perfil do usuario
     * @access public
     */
    public static function update($id, $name, $email, $type, $password, $password_confirmation, $patchImage) {
        if ($password_confirmation == $password) {
            if($patchImage != "default") {
                $newPatchImg = USer::copyImage($patchImage, $id);
                mysqli_query(Connection::getConnection(), "Update users set 
                    name='{$name}',
                    email='{$email}',
                    type='{$type}',
                    password='{$password}',
                    patchImage='{$newPatchImg}'
                    where id='{$id}'");
                if(empty($patchImage))
                    self::deleteImgProfile($id);
            }
            else {
                mysqli_query(Connection::getConnection(), "Update users set
                name='{$name}',
                email='{$email}',
                type='{$type}',
                password='{$password}'
                where id='{$id}'");
            }
        }
    }

    /**
     * Informa a identificacao de usuario
     * @return string Identificacao de usuario
     * @access public
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Informa o tipo de usuario 
     * @return string O tipo de usuario
     * @access public
     */
    public function getType(){
        return $this->type;
    }

    /**
     * Informa o nome de usuario
     * @return string Nome de usuario
     * @access public
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Informa o email de usuario
     * @return string Email de usuario
     * @access public
     */
    public function getEmail(){
        return $this->email;
    }
    
    /**
     * Informa a senha de usuario
     * @return string Senha de usuario
     * @access public
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * Informa o diretorio da imagem de perfil de usuario
     * @return string Caminho da imagem de perfil
     * @access public
     */
    public function getPatchProfileImg() {
        if(empty($this->patchProfileImg))
            return "/Treinamento2020/img/profileImages/Newbie".imgExtension;
        return $this->patchProfileImg;
    }

    /**
     * Trasfere a imagem do cache do navegador diretamente para uma pasta do sistema (SO)
     * @param string $patch Caminho da imagem contida em cache
     * @param string $id Idenficacao de usuario
     * @return string Retorna o caminho da imagem criada ou retorna uma string vazia se a operacao falhar
     * @access private
     */
    private static function copyImage($patch, $id){
        if(move_uploaded_file($patch, "img/profileImages/{$id}".imgExtension)) //A nova imagem tera o nome igual ao id de usuario
            return "/Treinamento2020/img/profileImages/{$id}".imgExtension;
        return "";
    }

    /**
     * Informa o proximo valor de id que o banco de dados gerara na proxima insercao de dados 
     * @return number Novo id que o banco gerara
     * @access private
     */
    private static function getIdNewbieUser() {
        $result = mysqli_query(Connection::getConnection(), "Select auto_increment from 
        information_schema.tables where table_name = 'users' and table_schema = 'backend'");
        return (int) mysqli_fetch_assoc($result)["auto_increment"];
    }

    /**
     * Remove a imagem de usuario contida no sistema operacional
     * @param string $id Identificacao do usuario cuja imagem de perfil sera removida do sistema
     * @access public
     */
    private static function deleteImgProfile($id) {
        if( file_exists("profileImages/{$id}".imgExtension ))
            unlink("profileImages/{$id}".imgExtension);
    }
}
