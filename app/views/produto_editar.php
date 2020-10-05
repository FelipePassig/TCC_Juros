<?php
require __DIR__.'/../controllers/usuario.php';
  if (isset($_SESSION['mercado']['logado']) and $_SESSION['mercado']['logado'] = 'sim') {
  require __DIR__.'/cabecalho_geral.php';
  ?>
  <div class="ui mobile reversed equal width grid">
    <div class="column"></div>
    <div class="column">

      <div class="marginCad">
        <h1>
          <div class="ui horizontal divider">
            Editar Produto  
          </div>
        </h1>
      </div>
        <?php
        $conexaos = new Connection();
        $recebeConexao = $conexaos->conectar();
        $sql_produtos = "select distinct nome_produto,foto_produto,preco_prod,cod_produto,marca,nome_cat,desc_prod, peso_liq,percent_preco from produtos,mercado,categoria_prod where cnpj_prod = cnpj and cnpj = '{$_SESSION['mercado']['cnpj']}' and cod_cat_cod = cod_cat and cod_produto = '{$_GET['cod']}';";
        $produto = $recebeConexao->query($sql_produtos)->fetch(PDO::FETCH_ASSOC);
        $cod_produto = $_GET['cod'];
        ?>
      <form class="ui large form" method="post" action="../controllers/produto.php?acao=produto_editar" enctype='multipart/form-data'>
        <div class="ui stacked segment">


          <div class="fields">

            <div class="ten wide field">
              <label>Nome do Produto</label>
              <input name="nome_produto_editar" id="nome_produto" type="text" value="<?php echo $produto['nome_produto'] ?>" required placeholder="Ex.: Margarina Qualy">
            </div>

            <div class="six wide field">
              <label>Peso Liquido</label>
              <input name="peso_produto_editar" id="peso" placeholder="Ex.: 500g" type="text" required value="<?php echo $produto['peso_liq'] ?>">
            </div>
          </div>
          <div class="field">
            <label>Marca do Produto</label>
            <input name="marca_produto_editar" id="marca" type="text" required value="<?php echo $produto['marca'] ?>" placeholder="Qualy">
          </div>

          <div class="field">
            <label>Preço do Produto</label>
            <input type="number" placeholder="5,45" name="preco_prod_editar" required min="0" max="999" step="any" value="<?php echo $produto['preco_prod']?>">
          </div>

          <div class="field">
            <label>Percentual de Impostos</label>
            <input type="number" placeholder="5,45" name="preco_imposto_editar" required min="0" max="999" step="any" title="Preencha com a porcentagem que existe de imposto sobre esse produto" value="<?php echo $produto['percent_preco']?>">
          </div>

          <div class="field">
            <label>Descrição do Produto</label>
            <input name="descricao_produto_editar" id="descricao" type="text" value="<?php echo $produto['desc_prod'] ?>" required placeholder="Cremosa...">
          </div>

          <div class="field">
            <label>Categoria do Produto</label>
            <select class="ui fluid dropdown" name="cod_cat_editar" id="categoria" required>
              <option value="">Categoria</option>
              <?php
              $conexaos = new Connection();
              $recebeConexao = $conexaos->conectar();
              $sql_categorias = "select * from categoria_prod; ";
              $categoria = $recebeConexao->query($sql_categorias)->fetchAll(PDO::FETCH_ASSOC);
              foreach ($categoria as $categorias) {
                echo '<option value="' . $categorias['cod_cat'] . '">' . $categorias['nome_cat'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="field">
              <label>Foto do Produto</label>
              <input type='file' name='foto_produto_editar' placeholder="Escolha uma imagem"/>
          </div>

          <?php

                        if (isset($_GET['u']) and $_GET['u'] == 2) {
                            echo '<p>Escolha uma imagem menor</p>';

                        } elseif (isset($_GET['u']) and $_GET['u'] != 'e') {
                            echo '<p>" ' . $_GET['u'] . ' " não é um arquivo suportado</p>';
                        }

                        ?>
            <input type="hidden" value="<?=$cod_produto?>" name="cod_produto">
           <button type="submit" class="ui fluid large teal submit button bg_secundario" name="editar_produto">Atualizar</button>
         </div>
       </form>

     </div>
     <div class="column"></div>
   </div>
   <br>
   <br>
   <br>



 </body>
 <?php
}else{
  header('location: ../views/mercado_login.php');
}
?>