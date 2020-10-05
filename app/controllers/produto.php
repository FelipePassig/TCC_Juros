<?php
session_start();

require __DIR__ . "/../conexao/ConnectionProduto.php";
require __DIR__ . "/../models/Produto.php";

function produto_cadastro(){

    if (isset($_POST['cadastrar_produto'])) {

        $desc_prod = $_POST['desc_prod'];
        $peso_liq = $_POST['peso_liq'];
        $nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $preco_prod_un = $_POST['preco_prod'];
        $cod_cat_cod = $_POST['cod_cat'];
        $marca = $_POST['marca'];
        $cnpj_merc = $_SESSION['mercado']['cnpj'];
        $imposto = $_POST['percent_preco'];
        $produto = new Produto();
        
        $foto_produto=$produto->valida_imagem($_FILES['foto_produto']);

        if ($foto_produto == 1){
            $t = explode('.', $_FILES['foto_produto']['name']);
            $nome_foto_produto = time().'.'.$t[1];
            $p = explode(',', $preco_prod_un);
            $preco_prod = $p[0].''.$p[1];
            move_uploaded_file($_FILES['foto_produto']['tmp_name'], '../../imagens/foto_produto/'.$nome_foto_produto.'');
            $produto->salvar_produto($desc_prod, $peso_liq, $nome_produto, $preco_prod, $cod_cat_cod, $marca,$nome_foto_produto,$cnpj_merc,$imposto);
            header("location: ../views/mercado_paginaLog.php");
        }else{
            header("location: produto_cadastro.php?u=".$foto_produto."");
        }

    }else{
        header("location: produto_cadastro.php");
    }
}

function produto_editar(){

    if (isset($_POST['editar_produto'])) {

        $nome_produto = $_POST['nome_produto_editar'];
        $peso_liq = $_POST['peso_produto_editar'];
        $marca = $_POST['marca_produto_editar'];
        $preco_prod_editar = $_POST['preco_prod_editar'];
        $descricao = $_POST['descricao_produto_editar'];
        $categoria = $_POST['cod_cat_editar'];
        $cod_produto = $_POST['cod_produto'];
        $percent_preco = $_POST['preco_imposto_editar'];
        $produto = new Produto();
        $foto_produto = $produto->valida_imagem($_FILES['foto_produto_editar']);

        if ($foto_produto == 1) {
            $t = explode('.', $_FILES['foto_produto_editar']['name']);
            $nome_foto_produto = time() . '.' . $t[1];
            $p = explode(',', $preco_prod_editar);
            $preco_prod = $p[0] . '' . $p[1];
            move_uploaded_file($_FILES['foto_produto_editar']['tmp_name'], '../../imagens/foto_produto/' . $nome_foto_produto . '');
            $produto->editar_produto($peso_liq, $marca, $nome_foto_produto, $nome_produto, $descricao, $preco_prod, $categoria,$cod_produto,$percent_preco);
            header('location: ../views/mercado_paginaLog.php?atualizado=sim');
            echo "<script>alert('Editado')</script>";
        } else {
            header('location: ../views/mercado_paginaLog.php?atualizado=nao');
            echo "<script>alert('Erro,tente novamente')</script>";
        }
    }
}

function produto_delete(){
        $produto = new Produto();
        $cnpj = $_SESSION['mercado']['cnpj'];
        $cod_produto = $_GET['cod'];
        $produto->produto_delete($cnpj,$cod_produto);
        header('location: ../views/mercado_paginaLog.php');
        echo "<script>alert('Deletado')</script>";
}

if (isset($_GET['acao']) and function_exists($_GET['acao'])) {
    call_user_func($_GET['acao']);
}