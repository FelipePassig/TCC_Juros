<?php
session_start();
require __DIR__ . "/../conexao/Connection.php";
require __DIR__ . "/../models/Lista.php";

function getConexao(){
    $conexaos = new Connection();
    $recebeConexao = $conexaos->conectar();
    return $recebeConexao;
}

function salvar_lista(){
    if (isset($_POST['lista_finalizada'])) {
        $nome_lista = $_POST['nome_lista'];
        $cnpj_prod = $_POST['cnpj_prod'];
        $produtos_selecionados=[];
        $dadosLista = $_POST;
        unset($dadosLista['nome_lista']);
        unset($dadosLista['lista_finalizada']);
        $lista = new Lista();
        foreach ($dadosLista as $key => $value) {
            if ($value==1 and !is_null($value) and !is_null($key)) {
                $cod = explode("cod_", $key);
                $qtdItem = $dadosLista['qtd_item_'.$cod[1]];
                $produtos_selecionados[$cod[1]] = $qtdItem;
            }
            unset($produtos_selecionados[null]);
        }
        if (isset($produtos_selecionados) and $produtos_selecionados != null) {
        $lista->salvar_item_lista($produtos_selecionados,$nome_lista,$cnpj_prod);
        header('location: ../views/usuario_pagina.php');
        }else{
            header('location: ../views/usuario_nl.php?error=produto ');
        }
    }
}

function lista_delete(){
    $lista = new Lista();
    $cpf = $_SESSION['cpf'];
    $cod_lista = $_POST['cod_lista'];
    $lista->delete_lista($cpf,$cod_lista);
    header('location: ../views/usuario_pagina.php');
    echo "<script>alert('Deletado')</script>";
}

function dados_lista($cod_lista){
    $conexaoLista = getConexao();
    $cpf = $_SESSION['cpf'];
    $sql_dados_lista = "select cod_lista,valor_lista,nome_lista from lista,usuario where cpf_lista = cpf and cpf = '{$cpf}' and cod_lista = '{$cod_lista}';";
    $a = $conexaoLista->query($sql_dados_lista)->fetch(PDO::FETCH_ASSOC);
    $sql_dados_itens = "select cod_produto,peso_liq,marca,foto_produto,nome_produto,desc_prod,preco_prod,qtd_item_lista,percent_preco from item_lista,produtos where cod_produto_cod = cod_produto and cod_lista_cod = '{$cod_lista}';";
    $a['produtos'] = $conexaoLista->query($sql_dados_itens)->fetchAll(PDO::FETCH_ASSOC);
    return $a;
}

function excluir_item(){
    $item = new Lista();
    $cpf  = $_SESSION['cpf'];
    $cod_lista = $_POST['cod_lista'];
    $cod_produto = $_POST['cod_produto'];
    $preco_item = $_POST['preco_item'];
    $qtd_item = $_POST['qtd_item'];
    $valor_lista = $_POST['valor_lista'];
    $item->delete_produto($cpf,$cod_lista,$cod_produto,$preco_item,$qtd_item,$valor_lista);
    header('location: ../views/usuario_pagina.php');
}

function atualizar_lista()
{
    if (isset($_POST['lista_finalizada'])) {
        $cod_lista = $_POST['cod_lista'];
        $cpf = $_SESSION['cpf'];
        $produtos_selecionados = [];
        $dadosLista = $_POST;
        unset($dadosLista['lista_finalizada']);
        unset($dadosLista['uf']);
        unset($dadosLista['cidade']);
        unset($dadosLista['bairro']);
        $lista = new Lista();
        foreach ($dadosLista as $key => $value) {
            if ($value == 1 and!is_null($key) and !is_null($value)) {
                $cod = explode('cod_',$key);
                $qtd_item = $dadosLista['qtd_item_'.$cod[1]];
                $produtos_selecionados[$cod[1]] = $qtd_item;
            }
            unset($produtos_selecionados[null]);
        }
        $lista->atualizar_lista($produtos_selecionados,$cod_lista,$cpf);
        header('location: ../views/usuario_pagina.php');
    }
}

function nome_lista_qr(){
    if (isset($_POST['continuar'])) {
    $nome_lista = $_POST['nome_lista'];
    $cnpj = $_POST['mercado'];
    $lista_qr = new Lista();
    $lista_qr->salvar_lista_qr($nome_lista,$cnpj);
    header('location: ../views/usuario_nl_qr.php');
    }

}

function lista_qr(){
    if (!isset($_POST['lista_finalizada'])) {
        $conexaoLista = getConexao();
        $lista = new Lista();
        $cpf = $_SESSION['cpf'];
        $cod_prod = $_REQUEST['cod_produto'];
        $qtd_item = $_REQUEST['qtd_item'];
        $sql_cod_lista = "select cod_lista from lista,usuario where cpf_lista = cpf and cpf = '{$cpf}' order by cod_lista desc";
        $cod_lista = $conexaoLista->query($sql_cod_lista)->fetch(PDO::FETCH_ASSOC);
        $cod_lista = $cod_lista['cod_lista'];
        $lista->add_item_qr($cod_prod,$qtd_item,$cod_lista);
    }else{
         header('location: ../views/usuario_pagina.php');
    }
}


















if (isset($_GET['acao']) and function_exists($_GET['acao'])) {
    call_user_func($_GET['acao']);
}