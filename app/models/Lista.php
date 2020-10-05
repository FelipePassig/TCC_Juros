<?php
/**
 * Created by PhpStorm.
 * User: Luiza Farias
 * Date: 24/10/2019
 * Time: 15:32
 */

class Lista{

    public $cod_lista;
    public $valor_lista;
    public $cpf_lista;

    public $tipoUsuario;

    public $conexao_lista;


    public function __construct()
    {
        $this->tipoUsuario = 5;
        $conexao_objeto = new Connection();
        $this->conexao_lista = $conexao_objeto->conectar();
    }

    public function salvar_item_lista($produtos_selecionados, $nome_lista, $cnpj_lista){

        $cpf_lista = $_SESSION['cpf'];
        $sql_lista = "insert into lista(valor_lista,nome_lista,cpf_lista, cnpj_lista) values(0,'{$nome_lista}','{$cpf_lista}', '{$cnpj_lista}');";
        $this->conexao_lista->exec($sql_lista);

        $sql_consulta = "select distinct cod_lista from lista,usuario where cpf_lista = '{$_SESSION['cpf']}' and nome_lista = '{$nome_lista}';";
        $cod_lista = $this->conexao_lista->query($sql_consulta)->fetch(PDO::FETCH_ASSOC);

        foreach ($produtos_selecionados as $linha => $valor) {
            $sql_item_lista = "insert into item_lista(cod_produto_cod,cod_lista_cod,qtd_item_lista) values ('{$linha}','{$cod_lista['cod_lista']}','{$valor}');";
            $this->conexao_lista->exec($sql_item_lista);
        }


        $sql_cods = "select distinct cod_produto_cod from item_lista,lista,produtos,usuario where cpf_lista = cpf and cpf = '{$_SESSION['cpf']}' and cod_lista_cod = cod_lista and cod_lista = '{$cod_lista['cod_lista']}' and nome_lista = '{$nome_lista}';";
        $cods = $this->conexao_lista->query($sql_cods)->fetchAll(PDO::FETCH_ASSOC);


        foreach ($cods as $prod_selec => $array) {
            foreach ($array as $key => $cod) {

                $sql_qtd = "select distinct qtd_item_lista from item_lista,lista,produtos,usuario where cpf_lista = cpf and cpf = '{$_SESSION['cpf']}' and cod_lista_cod = cod_lista and cod_lista = '{$cod_lista['cod_lista']}' and nome_lista = '{$nome_lista}' and cod_produto_cod = cod_produto and cod_produto = '{$cod}';";
                $qtds = $this->conexao_lista->query($sql_qtd)->fetchAll(PDO::FETCH_ASSOC);
                $sql_preco_unit = "select preco_prod from produtos where cod_produto = '{$cod}';";
                $precos_unit = $this->conexao_lista->query($sql_preco_unit)->fetchAll(PDO::FETCH_ASSOC);

                foreach ($qtds as $key => $array) {
                    foreach ($array as $key => $qtd) {


                    }
                }

                foreach ($precos_unit as $key => $array) {
                    foreach ($array as $key => $preco) {

                    }
                }

                $cod_all[] = $cod;
                $qtd_all[] = $qtd;
                $preco_all[] = $preco;

            }
            $preco_mult = $qtd_all[$prod_selec] * $preco_all[$prod_selec];
            $preco_multiplicado[] = $preco_mult;
            $preco_multiplicado_s = array_sum($preco_multiplicado);
        }

        $sql_update_preco = "update lista set valor_lista = '{$preco_multiplicado_s}' where cod_lista = '{$cod_lista['cod_lista']}';";
        $this->conexao_lista->exec($sql_update_preco);

    }

    public function delete_lista($cpf, $cod_lista)
    {

        $sql_delete_item = "delete item_lista from item_lista,lista where cod_lista_cod = cod_lista and cod_lista = '{$cod_lista}';";
        $this->conexao_lista->exec($sql_delete_item);

        $sql_delete_lista = "delete from lista where cpf_lista = '{$cpf}' and cod_lista = '{$cod_lista}';";
        $this->conexao_lista->exec($sql_delete_lista);


    }

    public function delete_produto($cpf, $cod_lista, $cod_produto, $preco_item, $qtd_item, $valor_lista)
    {
        $sql_delete_item = "delete item_lista from item_lista,lista,usuario,produtos where cpf_lista = cpf and cpf = '{$cpf}' and cod_lista_cod = cod_lista and cod_lista = '{$cod_lista}' and cod_produto_cod = cod_produto and cod_produto = '{$cod_produto}';";
        $this->conexao_lista->exec($sql_delete_item);
        $aux = $preco_item * $qtd_item;
        $novo_preco = $valor_lista - $aux;
        $sql_update_preco_delete = "update lista set valor_lista = '{$novo_preco}' where cod_lista = '{$cod_lista}';";
        $this->conexao_lista->exec($sql_update_preco_delete);
        if ($novo_preco <= 0) {
            $sql_delete_lista_zero = "delete from lista where cpf_lista = '{$cpf}' and cod_lista = '{$cod_lista}';";
            $this->conexao_lista->exec($sql_delete_lista_zero);
        }
    }

    public function atualizar_lista($produtos_selecionados, $cod_lista, $cpf)
    {

        $sql_consulta = "select cod_lista from lista,usuario where cpf_lista = cpf and cpf = '{$cpf}' and cod_lista = '{$cod_lista}';";
        $cod_consulta = $this->conexao_lista->query($sql_consulta)->fetch(PDO::FETCH_ASSOC);
        $cood = $cod_consulta['cod_lista'];

        if ($cood == $cod_lista) {
            foreach ($produtos_selecionados as $cod => $qtd) {
                $sql_itens_ja_selec = "select cod_produto_cod,qtd_item_lista from item_lista,lista,usuario,produtos where cpf_lista = cpf and cpf = '{$cpf}' and cod_lista_cod = cod_lista_cod and cod_lista = '{$cod_lista}' and cod_produto_cod = cod_produto and cod_produto = '{$cod}';";
                $cod_consulta = $this->conexao_lista->query($sql_itens_ja_selec)->fetchAll(PDO::FETCH_ASSOC);

                if ($cod_consulta == false) {
                    $sql_item_lista = "insert into item_lista(cod_produto_cod,cod_lista_cod,qtd_item_lista) values ('{$cod}','{$cod_lista}','{$qtd}') ;";
                    $this->conexao_lista->exec($sql_item_lista);

                    $sql_preco_unit = "select preco_prod from produtos where cod_produto = '{$cod}';";
                    $precos_unit = $this->conexao_lista->query($sql_preco_unit)->fetch(PDO::FETCH_ASSOC);

                    foreach ($precos_unit as $preco_cod => $preco) {
                    }

                   $preco_prod_add = $preco * $qtd;

                    $sql_preco = "select valor_lista from lista where cod_lista = '{$cod_lista}';";
                    $preco_lista = $this->conexao_lista->query($sql_preco)->fetch(PDO::FETCH_ASSOC);

                    foreach ($preco_lista as $key => $preco_list) {
                    }

                    $preco_total = $preco_prod_add + $preco_list;

                    $sql_update_preco = "update lista set valor_lista = '{$preco_total}' where cod_lista = '{$cod_lista}';";
                    $this->conexao_lista->exec($sql_update_preco);
                }else{
                    foreach ($cod_consulta as $key => $value){

                        $qtd_add = $value['qtd_item_lista'] + $qtd;

                        $sql_update_qtd = "update item_lista set qtd_item_lista = '{$qtd_add}' where cod_produto_cod = '{$cod}' and cod_lista_cod = '{$cod_lista}';";
                        $this->conexao_lista->exec($sql_update_qtd);


                        $sql_preco_unit = "select cod_produto,preco_prod from produtos where cod_produto = '{$cod}';";
                        $precos_unit = $this->conexao_lista->query($sql_preco_unit)->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($precos_unit as $key => $array) {
                        }

                        $preco_all = $array;
                        $preco_prod_add = $preco_all['preco_prod'] * $qtd;

                        $sql_preco = "select valor_lista from lista where cod_lista = '{$cod_lista}';";
                        $preco_lista = $this->conexao_lista->query($sql_preco)->fetch(PDO::FETCH_ASSOC);

                        foreach ($preco_lista as $key => $preco_list) {
                        }

                        $preco_total = $preco_prod_add + $preco_list;

                        $sql_update_preco = "update lista set valor_lista = '{$preco_total}' where cod_lista = '{$cod_lista}';";
                        $this->conexao_lista->exec($sql_update_preco);

                    }
                }
            }

        }
    }

    public function salvar_lista_qr($nome_lista,$cnpj_lista){
        $cpf_lista = $_SESSION['cpf'];
        $sql_lista = "insert into lista(valor_lista,nome_lista,cpf_lista, cnpj_lista) values(0,'{$nome_lista}','{$cpf_lista}', '{$cnpj_lista}');";
        $this->conexao_lista->exec($sql_lista);
    }

    public function add_item_qr($cod_prod,$qtd_item,$cod_lista){
            $cpf = $_SESSION['cpf'];
            $sql_cod_exist = "select distinct qtd_item_lista from item_lista,lista,usuario,produtos where cpf_lista = cpf and cpf = '{$cpf}' and cod_lista_cod = cod_lista and cod_lista = '{$cod_lista}' and cod_produto_cod = '{$cod_prod}';";
            $cod_exist = $this->conexao_lista->query($sql_cod_exist)->fetch(PDO::FETCH_ASSOC);

            if($cod_exist == false){

                $sql_add_item = "insert into item_lista(cod_produto_cod,cod_lista_cod,qtd_item_lista) value('{$cod_prod}','{$cod_lista}','{$qtd_item}');";
                $this->conexao_lista->exec($sql_add_item);
                $sql_preco_item = "select preco_prod from produtos where cod_produto = '{$cod_prod}';";
                $preco_prod = $this->conexao_lista->query($sql_preco_item)->fetch(PDO::FETCH_ASSOC);
                $preco_add = $preco_prod['preco_prod'] * $qtd_item;
                $sql_preco_lista = "select valor_lista from lista,usuario where cpf_lista = cpf and cpf = '{$cpf}' and cod_lista = '{$cod_lista}';";
                $preco_lista = $this->conexao_lista->query($sql_preco_lista)->fetch(PDO::FETCH_ASSOC);
                $novo_preco_lista = $preco_add + $preco_lista['valor_lista'];
                $sql_update_preco = "update lista set valor_lista = '{$novo_preco_lista}' where cod_lista = '{$cod_lista}';";
                $this->conexao_lista->exec($sql_update_preco);

        }else{

                $qtd_add = $cod_exist['qtd_item_lista'] + $qtd_item;

                $sql_update_qtd = "update item_lista set qtd_item_lista = '{$qtd_add}' where cod_produto_cod = '{$cod_prod}' and cod_lista_cod = '{$cod_lista}';";
                $this->conexao_lista->exec($sql_update_qtd);

                $sql_preco_unit = "select preco_prod from produtos where cod_produto = '{$cod_prod}';";
                $precos_unit = $this->conexao_lista->query($sql_preco_unit)->fetch(PDO::FETCH_ASSOC);

                $preco_prod_add = $precos_unit['preco_prod'] * $qtd_item;

                $sql_preco = "select valor_lista from lista where cod_lista = '{$cod_lista}';";
                $preco_lista = $this->conexao_lista->query($sql_preco)->fetch(PDO::FETCH_ASSOC);


                foreach ($preco_lista as $key => $preco_list) {
                }

                $preco_total = $preco_prod_add + $preco_list;

                $sql_update_preco = "update lista set valor_lista = '{$preco_total}' where cod_lista = '{$cod_lista}';";
                $this->conexao_lista->exec($sql_update_preco);

        }

    }


}