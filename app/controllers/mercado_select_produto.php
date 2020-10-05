<?php
		require __DIR__.'/../conexao/Connection.php';
        $conexao = new Connection();
        $recebeConexao = $conexao->conectar();

        //recebe o codigo do estado selecionado
        $cod_mercado = $_POST['cod_mercado'];
        $sql_produto= "select distinct nome_produto,foto_produto,preco_prod,cod_produto,marca,nome_cat,desc_prod, peso_liq,cnpj_prod,nome_mercado,percent_preco from produtos,mercado,categoria_prod where cnpj_prod = cnpj and cod_cat_cod = cod_cat and cnpj_prod = cnpj and cnpj = '{$cod_mercado}';";

        //pega as cidades do estado selecionado
        $produtos = $recebeConexao->query($sql_produto)->fetchAll(PDO::FETCH_ASSOC);

        //adicionar as cidades para um array para enviar para a pagina e printar
        foreach ($produtos as $produto){
       	    $retorno[] = [
       	        'nome_produto'=>$produto['nome_produto'],
                'foto_produto'=>$produto['foto_produto'],
                'preco_prod'=>$produto['preco_prod'],
                'cod_produto'=>$produto['cod_produto'],
                'marca'=>$produto['marca'],
                'nome_cat'=>$produto['nome_cat'],
                'desc_prod'=>$produto['desc_prod'],
                'peso_liq'=>$produto['peso_liq'],
                'cnpj_prod'=>$produto['cnpj_prod'],
                'nome_mercado'=>$produto['nome_mercado'],
                'percent_preco'=>$produto['percent_preco']
            ];
		}

        //envia os dados
        echo json_encode($retorno);


        //file_put_contents("dados.txt",json_encode($retorno));

        //print_r(json_encode($retorno));



