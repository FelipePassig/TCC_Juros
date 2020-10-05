<?php
session_start();
require __DIR__.'/cabecalho_geral.php';
require __DIR__.'/../controllers/mercado.php';
?>
<body>
  <div class="ui horizontal divider cor_tercearia marginUsu">
    Mercados cadastrados
  </div>   
  <div class="ui grid">

    <?php
    $conexao = new Connection();
    $recebeConexao = $conexao->conectar();
    $sql_mercados = "select  count(cod_produto) as qtd_prod,nome_mercado,cnpj,telefone_mercado,foto_mercado,email_mercado from mercado,produtos where cnpj_prod = cnpj GROUP BY cnpj;";
    $mercado = $recebeConexao->query($sql_mercados)->fetchAll(PDO::FETCH_ASSOC);

    foreach ($mercado as $key => $value) {
      $cod_mercado = $value['cnpj'];
      echo '
     
      <div class="five wide column">
      <div class="ui cards ">
      <div class="card Cardssss">
      <div class="image">
      <img src="../../imagens/foto_mercado/'.$value['foto_mercado'].'">
      </div>
      <div class="content">
      <p class="ui sub header">Nome: '.$value['nome_mercado'].'</p>
      <p class="ui sub header">Telefone: '.$value['telefone_mercado'].'</p>
      <p class="ui sub header">Email: '.$value['email_mercado'].'</p>
      <p class="ui sub header">Produtos: '.$value['qtd_prod'].'</p>
      </div>
      </div>
      </div>
      <br>
      <br> 
      </div>
      

      ';


    }
    ?>
    <div class="two wide column "></div>
  </div>
  
</body>
<?php //include "footer.php"  ?>