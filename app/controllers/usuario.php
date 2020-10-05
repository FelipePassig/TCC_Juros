<?php
session_start();

require __DIR__."/../conexao/Connection.php";
require __DIR__."/../models/Usuario.php";

function pagina_usuario(){
    require __DIR__ . "/../views/usuario_pagina.php";
}

function getConexao(){
    $conexaos = new Connection();
    $recebeConexao = $conexaos->conectar();
    return $recebeConexao;

}
function usuario_cadastro(){
    $conexaoCadastro = getConexao();
    $primeiro_nome = filter_input(INPUT_POST, 'primeiro_nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $sobrenome = $_POST['sobrenome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = MD5($_POST['senha']);
    $sql_cpf = "select cpf from usuario where cpf = '{$cpf}'";
    $dados['cpf'] = $conexaoCadastro->query($sql_cpf)->fetch(PDO::FETCH_ASSOC);
    $sql_email = "select email from usuario where email = '{$email}'";
    $dados['email'] = $conexaoCadastro->query($sql_email)->fetch(PDO::FETCH_ASSOC);
    if ($dados['cpf'] != false) {
        header('location: ../views/usuario_cadastro.php?error=cpf');
    }elseif($dados['email'] != false){
        header('location: ../views/usuario_cadastro.php?error=email');
    }elseif(empty($dados['cpf']) and  empty($dados['email'])){
        $user = new Usuario();
        $user->salvar_usuario($primeiro_nome, $telefone, $sobrenome, $senha, $cpf, $email);
        header('location: ../views/usuario_login.php');
    }
}

function usuario_login(){
    $conexaoLogin = getConexao();
    #$user = new Usuario();
    if( isset($_POST['entrar']) ) {
        $email = $_POST['email_login'];
        $senha = $_POST['senha_login'];
        $query = "select cpf,senha, email  from usuario where email = '{$email}'";
        $dados = $conexaoLogin->query($query);
        $dadosUsuario=$dados->fetch(PDO::FETCH_ASSOC);
        if ($dados->rowCount()>0) {
            $senhaRetornada = $dadosUsuario['senha'];
            if(MD5($senha) == $senhaRetornada) {
                try{
                    $query = "select * from usuario where email = '{$dadosUsuario['email']}' and senha = '{$dadosUsuario['senha']}' and cpf = '{$dadosUsuario['cpf']}'";
                    $dadosRetornados = $conexaoLogin->query($query)->fetch(PDO::FETCH_ASSOC);
                    if(!isset($_SESSION)){
                        session_start();
                    }
                    if (isset($dadosRetornados['cpf'])) {
                        $_SESSION = $dadosRetornados;
                        $_SESSION['cpf'] = $dadosRetornados['cpf'];
                        $_SESSION['logado'] = "sim";
                        header('location: ../views/usuario_pagina.php');
                        }else{
                        $_SESSION['logado'] = "não";
                        header('location: ../views/usuario_login.php');
                    }


                }catch (Exception $e){
                    echo 'Error: ',  $e->getMessage(), "oidoiaodiwoidaoidoaw";
                }
            }else{
                header('location: ../views/usuario_login.php?error=senha');
            }
        }else{
            if ($email != $dadosUsuario['email']) {
                header('location: ../views/usuario_login.php?error=email');
            }
        }
    }
else{
    }
}

function usuario_editar(){
    if (isset($_POST['editar'])) {
       $primeiro_nome = filter_input(INPUT_POST, 'primeiro_nome_editar', FILTER_SANITIZE_SPECIAL_CHARS);
       $sobrenome = $_POST['sobrenome_editar'];
       $telefone = $_POST['telefone_editar'];
       $email = $_POST['email_editar'];
       $senha = MD5($_POST['senha_editar']);
       $cpf = $_SESSION['cpf'];
       $user = new Usuario();
       $user->editar_usuario($primeiro_nome, $sobrenome, $telefone, $email, $senha, $cpf);
       header('location: ../views/usuario_pagina.php?atualizado=sim');
   }else{
       header('location: ../views/usuario_pagina.php?atualizado=nao');
   }
}


function usuario_delete(){
    if (isset($_SESSION['logado']) and $_SESSION['logado'] == 'sim'){
        $user = new Usuario();
        $cpf = $_SESSION['cpf'];
        $user->deletar_usuario($cpf);
        session_destroy();
        header('location: ../views/home.php');
    }else{
        header('location: ../views/usuario_pagina.php');    
    }
}

function usuario_deslogar(){

    header('location: ../views/home.php');
    $_SESSION['logado'] = "nao";
    unset($_SESSION['cpf']);
    unset($_SESSION['sobrenome']);
    unset($_SESSION['senha']);
    unset($_SESSION['email']);
    unset($_SESSION['primeiro_nome']);
    unset($_SESSION['telefone']);
    unset($_SESSION['cod_tip_usu_cod']);
}

if (isset($_GET['acao']) and function_exists($_GET['acao']) ){
    call_user_func($_GET['acao']);
}