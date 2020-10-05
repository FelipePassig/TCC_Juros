<?php
		require __DIR__.'/../conexao/Connection.php';
        $conexao = new Connection();
        $recebeConexao = $conexao->conectar();

        //recebe o codigo do estado selecionado
        $cod_cidade = $_POST['cod_cidade'];
        $sql_bairro= "select cod_bairro,nome_bairro from bairro,cidade where cod_cidade = cod_cidade_cod and cod_cidade = {$cod_cidade}";

        //pega as cidades do estado selecionado
        $bairros = $recebeConexao->query($sql_bairro)->fetchAll(PDO::FETCH_ASSOC);

        //adicionar as cidades para um array para enviar para a pagina e printar
        foreach ($bairros as $bairro){
       	    $retorno[] = [
       	        'nome_bairro'=>$bairro['nome_bairro']
                ,'cod_bairro'=>$bairro['cod_bairro']
            ];
		}

        //envia os dados
        echo json_encode($retorno);


        //file_put_contents("dados.txt",json_encode($retorno));

        //print_r(json_encode($retorno));
?>


