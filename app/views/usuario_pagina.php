<?php
session_start();
if (isset($_SESSION['logado']) and $_SESSION['logado'] == 'sim'){
  require __DIR__.'/cabecalho_geral.php';
  require __DIR__.'/../conexao/Connection.php';
  ?>

  <body>

   <div class="ui width grid">
    <div class="one wide column "></div>
    <div class="fourteen wide column">

      <div class="ui middle aligned divided list marginUsu">
        <div class="item">
          <div class="right floated content">
            <a href="usuario_editar.php"><div class="ui button">Editar</div></a>
            
            <?php

            ?>
          </div>
          <div class="header"><h3><?php echo $_SESSION['primeiro_nome'].' '.$_SESSION['sobrenome'] ?></h3></div>
          <div class="ui horizontal bulleted list">
            <div class="item"><?php echo $_SESSION['email'] ?></div>
            <div class="item"><?php echo $_SESSION['cpf'] ?></div>
            <div class="item"><?php echo $_SESSION['telefone'] ?></div>
          </div>
        </div>
      </div>

      <div class="dropp">
        <a href="usuario_nl.php">
        <button class="ui primary button direita">+ Nova lista Sem QrCode</button>
      </a>
      <a href="nome_lista_qr.php">
        <button class="ui primary button direita">+ Nova lista Com QrCode</button>
      </a>
      </div>

      <div class="ui horizontal divider cor_tercearia">
        Minhas listas
      </div>
          
  
       <div class="ui grid">


      <?php
      $conexaos = new Connection();
      $recebeConexao = $conexaos->conectar();
      $sql_cnpj_lista = "SELECT DISTINCT cnpj_lista,foto_mercado,nome_mercado from usuario, mercado, lista where cnpj_lista = cnpj and cpf_lista = cpf and cpf = '{$_SESSION['cpf']}';";
      $cnpjs = $recebeConexao->query($sql_cnpj_lista)->fetch(PDO::FETCH_ASSOC);

      $sql_produtos = "select distinct nome_lista,valor_lista,cod_lista from lista,usuario where cpf_lista = cpf and cpf = '{$_SESSION['cpf']}'";
      $produtos = $recebeConexao->query($sql_produtos)->fetchAll(PDO::FETCH_ASSOC);


      for ($i= 0; $i < sizeof($produtos) ; $i++) {
          foreach ($cnpjs as $key =>$cnpj){
              $produtos[$i][$key] = $cnpj;
              $produtos[$i][$key] = $cnpj;
              $produtos[$i][$key] = $cnpj;
          }
      }




      foreach ($produtos as $key => $produto) {
      $cod_lista = $produto['cod_lista'];

          $sql_produtos_qtd = "select sum(qtd_item_lista) as qtd_prod_lista from item_lista,lista,usuario where cpf_lista = cpf and cpf = '{$_SESSION['cpf']}' and cod_lista_cod = cod_lista and cod_lista = '{$cod_lista}' ;";
          $produtos_cad = $recebeConexao->query($sql_produtos_qtd)->fetchAll(PDO::FETCH_ASSOC);

          $sql_valor_imposto = "select cod_produto_cod from item_lista,lista where cod_lista_cod = cod_lista and cod_lista = '{$produto['cod_lista']}';";
          $cod_produto_imp = $recebeConexao->query($sql_valor_imposto)->fetchAll(PDO::FETCH_ASSOC);

          foreach($cod_produto_imp as $key=> $cod_prod_imp){
            foreach($cod_prod_imp as $key => $cod_imp){
              $sql_valor_ind_imp = "select percent_preco,preco_prod,qtd_item_lista from produtos,item_lista,lista where cod_lista_cod = cod_lista and cod_lista = '{$produto['cod_lista']}' and cod_produto_cod = cod_produto and cod_produto = '{$cod_imp}';";
              $valor_ind_imp = $recebeConexao->query($sql_valor_ind_imp)->fetch(PDO::FETCH_ASSOC);
              $valor_do_imp = ($valor_ind_imp['percent_preco'] * $valor_ind_imp['preco_prod'])/100;
              $valor_do_imp_mult = $valor_do_imp * $valor_ind_imp['qtd_item_lista'];
              $valor_total_imp[$produto['cod_lista']][] = $valor_do_imp_mult;
              $valor_imposto_final = array_sum($valor_total_imp[$produto['cod_lista']]);
            }
          }
          ?>

        
<div class="four wide column  ">
    <div class="ui special cards Cardsss">
      <div class="card">
  <div class="content">
    <div class="header"><?php echo $produto['nome_lista'] ?></div>
  </div>
  <div class="content">
    <div class="ui sub "><?php echo "Valor total R$".$produto['valor_lista']."" ?></div>
    <div class="ui sub"><?php echo "Valor total de impostos pagos R$".$valor_imposto_final."" ?></div>
    <div class="ui small feed">
      <div class="event">
        <div class="content">
          <div class=" ui sub ">
             <?=$produtos_cad[0]['qtd_prod_lista']?> Itens
              <br>
            Mercado: <?php echo $produto['nome_mercado']; ?>
          </div>

        </div>
      </div>
  </div>
 <div class="extra content">
          <form action="../views/confirmacao_exclusao_lista.php" method="post" class="botaoform2">
            <button value="<?php echo $produto['cod_lista'];?>" name="cod_lista" class="ui left button red tiny">Excluir</button>
          </form>
          <form action="../views/lista_vizualizar.php" method="post" class="botaoform">
            <button value="<?php echo $produto['cod_lista'];?>" name="cod_lista" class="ui right floated button green tiny">Vizualizar</button>
            <input type="hidden" name="cnpj" value="<?=$cnpjs['cnpj_lista']?>">
            <input type="hidden" name="imposto" value="<?=$valor_imposto_final?>">
          </form>
        </div>
</div>
</div>


        
      

    </div>
  </div>
<?php
}?>
</div>
<div class="one wide column "></div>
</div>
</div>

</body>
<?php
  //include 'footer.php';
}else{
 header('location: ../views/usuario_login.php');
}