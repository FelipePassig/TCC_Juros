<?php
		require __DIR__.'/../conexao/Connection.php';
        $conexao = new Connection();
        $recebeConexao = $conexao->conectar();

        //recebe o codigo do estado selecionado
        $cod_bairro = $_POST['cod_bairro'];
        $sql_mercado= "select cnpj,nome_mercado from bairro,mercado,endereco where cod_bairro = cod_bairro_cod and cod_bairro = '{$cod_bairro}' and cnpj = cnpj_end ;";

        //pega as cidades do estado selecionado
        $mercados = $recebeConexao->query($sql_mercado)->fetchAll(PDO::FETCH_ASSOC);

        //adicionar as cidades para um array para enviar para a pagina e printar
        foreach ($mercados as $mercado){
       	    $retorno[] = [
       	        'nome_mercado'=>$mercado['nome_mercado']
                ,'cnpj'=>$mercado['cnpj']
            ];
		}

        //envia os dados
        echo json_encode($retorno);


        //file_put_contents("dados.txt",json_encode($retorno));

        //print_r(json_encode($retorno));
?>


