<?php
		require __DIR__.'/../conexao/Connection.php';
        $conexao = new Connection();
        $recebeConexao = $conexao->conectar();

        //recebe o codigo do estado selecionado
        $cod_uf = $_POST['cod_uf'];
        $sql_cidade= "select cod_cidade,nome_cidade from cidade,uf where cod_uf = cod_uf_cod and cod_uf = {$cod_uf};";

        //pega as cidades do estado selecionado
        $cidades = $recebeConexao->query($sql_cidade)->fetchAll(PDO::FETCH_ASSOC);

        //adicionar as cidades para um array para enviar para a pagina e printar
        foreach ($cidades as $cidade){
       	    $retorno[] = [
       	        'nome_cidade'=>$cidade['nome_cidade']
                ,'cod_cidade'=>$cidade['cod_cidade']
            ];
		}

        //envia os dados
        echo json_encode($retorno);


        //file_put_contents("dados.txt",json_encode($retorno));

        //print_r(json_encode($retorno));
?>


