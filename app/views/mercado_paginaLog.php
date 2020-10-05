<?php
session_start();
require __DIR__.'/../controllers/usuario.php';
require __DIR__.'/../controllers/produto.php';
if (isset($_SESSION['mercado']['logado']) and $_SESSION['mercado']['logado'] == "sim") {
  require __DIR__.'/cabecalho_geral.php';
  ?>
  <body>

   <div class="ui width grid">
    <div class="one wide column "></div>
    <div class="fourteen wide column">

      <div class="ui middle aligned divided list marginUsu">
        <div class="item">
          <div class="right floated content">
            <a href="../views/mercado_editar.php">
              <div class="ui button">Editar</div>
            </a>
          </div>
          <img class="ui avatar image" src="../../imagens/foto_mercado/<?php echo $_SESSION['mercado']['foto_mercado'] ?>">
          <div class="header"><h3><?php echo $_SESSION['mercado']['nome_mercado']?></h3></div>
          <div class="ui horizontal bulleted list">
            <div class="item"><?php echo $_SESSION['mercado']['cnpj']?></div>
            <div class="item"><?php echo $_SESSION['mercado']['email_mercado']?></div>
            <div class="item"><?php echo $_SESSION['mercado']['telefone_mercado']?></div>
            <div class="item"><?php echo $_SESSION['mercado']['ie']?></div>
          </div>
        </div>
      </div>
      <a href="../views/produto_cadastro.php">
        <button class="ui primary button direita">+ Novo produto</button>
      </a>

      <section class="novaLista margin">
        <a href="../controllers/mercado.php?acao=mercado_deslogar" >
          <button class="ui button direita red" >Deslogar</button>
        </a>
      </section>

      <div class="ui horizontal divider cor_tercearia ">
        meus produtos
      </div>

      <div class="ui grid">


        <?php
        $conexaos = new Connection();
        $recebeConexao = $conexaos->conectar();
        $sql_produtos = "select distinct nome_produto,foto_produto,preco_prod,cod_produto,marca,nome_cat,desc_prod, peso_liq,percent_preco from produtos,mercado,categoria_prod where cnpj_prod = cnpj and cnpj = '{$_SESSION['mercado']['cnpj']}' and cod_cat_cod = cod_cat;";
        $produto = $recebeConexao->query($sql_produtos)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($produto as $key => $value) {
          $cod_prod = $value['cod_produto'];
          $aux_preco_imposto = $value['preco_prod'] * $value['percent_preco'];
          $preco_imposto = $aux_preco_imposto/100;
          echo '

          <div class="ui card top limit">
          <div class="content">
          <div class="header">'.$value['nome_produto'] .'</div>
          </div>
          <div class="image produtoFoto"> 
            <img width="600" height="100" src="../../imagens/foto_produto/'.$value['foto_produto'].'"> 
          </div>
          <div class="content">
          <p class="ui sub header">Categoria: '.$value['nome_cat'].'</p>
          <p class="ui sub header">Preço: R$'.$value['preco_prod'].'</p>
          <p class="ui sub header">Preço pago de impostos: R$'. $preco_imposto .'</p>
          <p class="ui sub header">Peso: '.$value['peso_liq'].'</p>
          <p class="ui sub header">Marca: '.$value['marca'].'</p>
          <p class="ui sub header">descrição: '.$value['desc_prod'].'</p>
          </div>
          <div class="extra content">
          <a href="../views/produto_editar.php?cod='.$cod_prod.'">
          <button class="ui left floated button blue small" id="editar_produto">Editar</button>
          </a>
          <a href="../views/confirmacao_exclusao_prod.php?cod='.$cod_prod.'">
          <button class="ui left button red small botaoExc">Excluir</button>
          </a>
          <form action="../views/qr_generator.php" method="post">
          <button type="submit" class="ui left button green small">QR</button>
          <input type="hidden" name="cod_prod" value="'.$cod_prod.'">
          <input type="hidden" name="nome_produto" value="'.$value['nome_produto'].'">
          </form>
          
          </div>
          </div>
          ';
        }
        ?>


      </div>
    </div>

</div>

  </body>
  <?php
    //include "footer.php";
}else{
  header('location: mercado_login.php');
}

