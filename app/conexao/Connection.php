<?php
class Connection {

    private static $conexao;

    public function conectar(){
        try{
            if (!isset(self::$conexao)) {
                self::$conexao = new PDO("mysql:host=localhost; dbname=qrlist;charset=UTF8","root","");
//                echo"deu certo ";
            }

        }catch(Exception $e){
            echo "Erro ao conectar ao banco ".$e->getMessage(); //método
        }
        return self::$conexao;
    }
}
