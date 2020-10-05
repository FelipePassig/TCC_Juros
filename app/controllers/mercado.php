<?php
session_start();
require __DIR__."/../conexao/Connection.php";
require __DIR__."/../models/Mercado.php";

if (isset($_GET['acao']) and function_exists($_GET['acao']) ){
    call_user_func($_GET['acao']);
}

function getConexao(){
    $conexaos = new Connection();
    $recebeConexao = $conexaos->conectar();
    return $recebeConexao;

}

function todos_mercados(){
    $conexaoSelectMercado = getConexao();
    $sql_all = "select count(cnpj) as quantidade from mercado;";
    $todos_mercados['contagem'] = $conexaoSelectMercado->query($sql_all)->fetch(PDO::FETCH_ASSOC);
    return $todos_mercados['contagem'];
}

function seleciona_uf(){
    $conexaoSelectMercado = getConexao();
    $sql_uf = "select * from uf order by nome_uf asc ";
    $dados['uf'] = $conexaoSelectMercado->query($sql_uf)->fetch(PDO::FETCH_ASSOC);
    return $dados['uf'];
}

function seleciona_cidade($cod_uf){
    $conexaoSelectMercado = getConexao();
    $sql_cidade = "select * from cidade where cod_uf_cod = '{$cod_uf}' ";
    $dados['cidade'] = $conexaoSelectMercado->query($sql_cidade)->fetch(PDO::FETCH_ASSOC);
}

function seleciona_bairro($cod_uf, $cod_cidade){
    $conexaoSelectMercado = getConexao();
    $sql_bairro = "select * from bairro where cod_uf_cod = '{$cod_uf}' and cod_cidade_cod = '{$cod_cidade}' ";
    $dados['bairro'] = $conexaoSelectMercado->query($sql_bairro)->fetch(PDO::FETCH_ASSOC);
}

function mercado_cadastro(){

if (isset($_POST['cadastrar_mercado'])) {

    $conexaoCadastroMercado = getConexao();
    
    $nome_mercado = filter_input(INPUT_POST, 'nome_mercado', FILTER_SANITIZE_SPECIAL_CHARS);
    $cnpj = $_POST['cnpj'];
    $senha_mercado = MD5($_POST['senha_mercado']);
    $ie = $_POST['ie'];
    $email_mercado = $_POST['email_mercado'];
    $telefone_mercado = $_POST['telefone_mercado'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $mercado = new Mercado();
    $foto_mercado=$mercado->valida_foto($_FILES['foto_mercado']);
    $sql_cnpj = "select cnpj from mercado where cnpj = '{$cnpj}';";
    $dados['cnpj'] = $conexaoCadastroMercado->query($sql_cnpj)->fetch(PDO::FETCH_ASSOC);
    $sql_email = "select email_mercado from mercado where email_mercado = '{$email_mercado}';";
    $dados['email_mercado'] = $conexaoCadastroMercado->query($sql_email)->fetch(PDO::FETCH_ASSOC);
    $sql_ie = "select ie from mercado where ie = '{$ie}';";
    $dados['ie'] = $conexaoCadastroMercado->query($sql_ie)->fetch(PDO::FETCH_ASSOC);
    
    if ($dados['cnpj'] != false) {
        header('location: ../views/mercado_cadastro.php?error=cnpj');
    } elseif ($dados['email_mercado'] != false) {
        header('location: ../views/mercado_cadastro.php?error=email_mercado');
    }elseif ($dados['ie'] != false){
        header('location: ../views/mercado_cadastro.php?error=ie');
    }elseif (empty($dados['cnpj']) and empty($dados['email'])) {

     if ($foto_mercado == 1){
     $t = explode('.', $_FILES['foto_mercado']['name']);
     $nome_foto_mercado = time().'.'.$t[1];
     move_uploaded_file($_FILES['foto_mercado']['tmp_name'], '../../imagens/foto_mercado/'.$nome_foto_mercado.'');
     $mercado->salvar_mercado($nome_mercado, $senha_mercado, $cnpj, $ie, $email_mercado, $telefone_mercado, $rua, $numero, $cep, $bairro, $cidade, $uf, $nome_foto_mercado);
    header("location: ../views/mercado_login.php");
        }else{
            header("location: mercado_cadastro.php?u=".$foto_mercado."");
        }

    }
}
}

function mercado_login(){
    $conexaoMercadoLogin = getConexao();
    $mercado = new Mercado();
    if (isset($_POST['entrar_mercado'])) {

        $email = $_POST['email_login_mercado'];
        $senha = $_POST['senha_login_mercado'];
        $query = "select cnpj,senha_mercado, email_mercado  from mercado where email_mercado = '{$email}';";
        $dados = $conexaoMercadoLogin->query($query);
        $dadosMercado=$dados->fetch(PDO::FETCH_ASSOC);
        if ($dados->rowCount()>0) {
            $senhaRetornada = $dadosMercado['senha_mercado'];
            if(MD5($senha) == $senhaRetornada) {
                try{
                    $query = "select * from mercado where email_mercado = '{$dadosMercado['email_mercado']}' and senha_mercado = '{$dadosMercado['senha_mercado']}' and cnpj = '{$dadosMercado['cnpj']}';";
                    $dadosRetornadosMercado = $conexaoMercadoLogin->query($query)->fetch(PDO::FETCH_ASSOC);
                    $queryEnd = "select rua,cep,numero from endereco,mercado where email_mercado = '{$dadosMercado['email_mercado']}' and senha_mercado = '{$dadosMercado['senha_mercado']}' and cnpj = '{$dadosMercado['cnpj']}';";
                    $dadosRetornadosMercadoEnd = $conexaoMercadoLogin->query($queryEnd)->fetch(PDO::FETCH_ASSOC);
                    if(!isset($_SESSION)){
                        session_start();
                    }
                    if (isset($dadosRetornadosMercado['cnpj'])) {
                        $_SESSION['mercado'] = $dadosRetornadosMercado;
                        $_SESSION['end'] = $dadosRetornadosMercadoEnd;
                        $_SESSION['mercado']['cnpj'] = $dadosRetornadosMercado['cnpj'];
                        $_SESSION['mercado']['logado'] = "sim";
                        header('location: ../views/mercado_paginaLog.php');
                    }else{
                        $_SESSION['mercado']['logado_mercado'] = "não";
                        header('location: /../views/mercado_login.php');
                    }


                }catch (Exception $e){
                    echo 'Error: ',  $e->getMessage(), "error";
                }
            }
        else{
                header('location: ../views/mercado_login.php?error=senha_mercado');
            }
        }else{
            if ($email != $dadosMercado['email']) {
                header('location: ../views/mercado_login.php?error=email_mercado');
            }
        }
    }else{
       header('location: /../views/mercado_login.php');
    }
}

function mercado_deslogar(){
    session_start();
    header('location: ../views/home.php');
    $_SESSION['mercado'] = null;
    $_SESSION['mercado']['logado'] = 'nao';
}

function mercado_editar(){
    if (isset($_POST['editar_mercado'])) {
       $nome_mercado = filter_input(INPUT_POST, 'nome_mercado_editar', FILTER_SANITIZE_SPECIAL_CHARS);
       $telefone = $_POST['telefone_mercado_editar'];
       $email = $_POST['email_mercado_editar'];
       $senha = MD5($_POST['senha_mercado_editar']);
       $cnpj = $_SESSION['mercado']['cnpj'];
       $bairro = $_POST['bairro_editar'];
       $cidade = $_POST['cidade_editar'];
       $uf = $_POST['uf_editar'];
       $cep = $_POST['cep_editar'];
       $rua = $_POST['rua_editar'];
       $numero = $_POST['numero_editar'];
       $user = new Mercado();
       $user->editar_mercado($nome_mercado, $telefone, $email, $senha, $cnpj,$bairro,$cidade,$uf,$cep,$numero,$rua);
       header('location: ../views/mercado_paginaLog.php?atualizado=sim');
               echo "<script>alert('Editado')</script>";

   }else{
       header('location: ../views/mercado_paginaLog.php?atualizado=nao');
               echo "<script>alert('Erro,tente novamente')</script>";

   }
}

function mercado_delete(){
    if (isset($_SESSION['mercado']['logado']) and $_SESSION['mercado']['logado'] == 'sim'){
        $user = new Mercado();
        $cnpj = $_SESSION['mercado']['cnpj'];
        $user->deletar_mercado($cnpj);
        header('location: ../views/home.php');
        $_SESSION['mercado']['logado'] = 'nao';
    }else{
        header('location: ../views/mercado_paginaLog.php');
    }
}
