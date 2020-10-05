<?php

class Usuario {

    //ATRIBUTOS DA CLASSE
    public $cpf;
    public $primeiro_nome;
    public $sobrenome;
    public $telefone;
    public $email;
    public $senha;
    public $tipoUsuario; //1 para comum e 2 para admin

    public $conexao_usuario;

    public function __construct(){
        $this->tipoUsuario = 1;
        $conexao_objeto = new Connection();
        $this->conexao_usuario = $conexao_objeto->conectar();
    }

    public function salvar_usuario($primeiro_nome, $telefone, $sobrenome, $senha, $cpf, $email){
        $sql_resultado = "insert into usuario(primeiro_nome, telefone, sobrenome, senha, cpf, email, cod_tip_usu_cod) values ('{$primeiro_nome}', '{$telefone}', '{$sobrenome}', '{$senha}', '{$cpf}', '{$email}', 1)";
        $resultado_usuario = $this->conexao_usuario->exec($sql_resultado);
        return $resultado_usuario;
    }

    public function deletar_usuario($cpf){
        $sql_delete = "delete from usuario where cpf = '{$cpf}'";
        $this->conexao_usuario->exec($sql_delete);
    }

    public function editar_usuario($primeiro_nome, $sobrenome, $telefone, $email, $senha, $cpf){

        $sql_editar = "update usuario set primeiro_nome='{$primeiro_nome}', sobrenome ='{$sobrenome}', email='{$email}', senha='{$senha}', telefone = '{$telefone}' WHERE cpf = '{$cpf}'";
        $this->conexao_usuario->exec($sql_editar);
        $_SESSION['primeiro_nome'] = $primeiro_nome;
        $_SESSION['sobrenome'] = $sobrenome;
        $_SESSION['telefone'] = $telefone;
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
    }
}