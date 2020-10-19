<?php

/**
 * Entidade responsavel por estabelecer conexao com o banco de dados
 * @author EcompJr
 *
 * @access public
 */
abstract class Connection{
    private static $connection;
    
    /**
     * Estabelece conexao com o banco de dados
     * @return mysqli_connect A conexao com o banco
     */
    public static function getConnection(){
        if(!self::$connection){
            self::$connection = mysqli_connect("localhost", "root", "", "backend");
        }
        return self::$connection;
    }

}