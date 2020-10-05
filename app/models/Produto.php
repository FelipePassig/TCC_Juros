<?php

class Produto{


    public $desc_prod;
    public $peso_liq;
    public $nome_produto;
    public $preco_prod;
    public $foto_produto;
    public $qtd_item_est;
    public $cod_produto;
    public $cod_cat_cod;
    public $marca;

    public $tipoUsuario;

    public $conexao_produto;
//
//
    //COMPORTAMENTOS
    public function __construct(){
        $this->tipoUsuario = 4;
        $conexao_objeto = new ConnectionProduto();
        $this->conexao_produto = $conexao_objeto->conectarProduto();
    }


    public function salvar_produto($desc_prod, $peso_liq, $nome_produto, $preco_prod, $marca, $cod_cat_cod, $nome_foto_produto,$cnpj_merc,$imposto){
        $auximposto = $imposto * $preco_prod;
        $preco_imposto = $auximposto/100;
        $sql_produto = "insert into produtos(desc_prod, peso_liq, nome_produto, preco_prod, foto_produto, marca, cod_cat_cod,cnpj_prod,percent_preco) values ('{$desc_prod}', '{$peso_liq}', '{$nome_produto}', '{$preco_prod}', '{$nome_foto_produto}', '{$cod_cat_cod}' , '{$marca}', '{$cnpj_merc}', '{$preco_imposto}');";
        $this->conexao_produto->exec($sql_produto);
    }

    public function valida_imagem($foto_produto){

        if ($foto_produto['type'] == 'image/png' or $foto_produto['type'] == 'image/jpeg' ){

            if ($foto_produto['size'] > 400000000000){
                return 2; //ESCOLHA UMA IMAGEM MENOR
            }else{
                return 1; //IMAGEM VALIDA
            }

        }elseif ($foto_produto['type'] == 'image/jpg'){

            if ($foto_produto['size'] > 400000000000){
                return 2; //ESCOLHA UMA IMAGEM MENOR
            }else{
                return 1; //IMAGEM VALIDA
            }

        }elseif (empty($foto_produto['name'])){
            return 4; //SEM IMAGEM
        }else{
            $nome = explode('.', $foto_produto['name']);
            return $nome[1]; //ESCOLHA UMA IMAGEM VALIDA
        }

    }

    public function editar_produto($peso_liq,$marca,$nome_foto_produto,$nome_produto,$descricao,$preco_prod,$categoria,$cod_produto,$percent_preco){

        $sql_editar_produto = "update produtos set peso_liq = '{$peso_liq}', marca = '{$marca}', foto_produto = '{$nome_foto_produto}', nome_produto = '{$nome_produto}', desc_prod = '{$descricao}', preco_prod = '{$preco_prod}', cod_cat_cod = '{$categoria}', percent_preco = '{$percent_preco}' where cod_produto = '{$cod_produto}';";
        $this->conexao_produto->exec($sql_editar_produto);
    }

    public function produto_delete($cnpj,$cod_produto){
        $sql_delete_produto = "delete from produtos where cnpj_prod = '{$cnpj}' and cod_produto = '{$cod_produto}';";
        $this->conexao_produto->exec($sql_delete_produto);
    }





}