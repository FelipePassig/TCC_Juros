<?php
session_start();
    if (isset($_SESSION['mercado']['logado']) and $_SESSION['mercado']['logado'] = 'sim') {
        require __DIR__ . '/cabecalho_geral.php';
        require __DIR__.'/../conexao/Connection.php';
        ?>
        <body>

        <div class="ui mobile reversed equal width grid footerM">
            <div class="column footerM"></div>
            <div class="column footerM">

                <div class="marginCadM">
                    <h1>
                        <div class="ui horizontal divider">
                            Cadastro de produto
                        </div>
                    </h1>
                </div>

                <form class="ui large form" method="post" action="../controllers/produto.php?acao=produto_cadastro"
                      enctype='multipart/form-data'>
                    <div class="ui stacked segment">

                        <div class="fields">

                            <div class="ten wide field">
                                <label>Nome do Produto</label>
                                <input type="text" name="nome_produto" placeholder="Ex.: Margarina Qualy" required>
                            </div>

                            <div class="six wide field">
                                <label>Peso Liquido</label>
                                <input type="text" name="peso_liq" placeholder="500g" required>
                            </div>

                        </div>

                        <div class="fields">

                            <div class="eight wide field">
                                <label>Preço</label>
                                <input type="number" placeholder="5,45" name="preco_prod" required min="0" max="999" value="0" step="any">
                            </div>
                            <div class="eight wide field">
                                <label>Percentual de Impostos</label>
                                <input type="number" placeholder="10" name="percent_preco" required min="0" max="100" value="0" step="any" title="Preencha com a porcentagem que existe de imposto sobre esse produto">
                            </div>

                        </div>

                        <div class="field">
                            <label>Marca do Produto</label>
                            <input type="text" name="marca" placeholder="Qualy" required>
                        </div>

                        <div class="field">
                            <label>Descrição do Produto</label>
                            <input type="text" name="desc_prod" placeholder="Cremosa..." required>
                        </div>

                                        <div class="field">
                                              <label>Categoria do Produto</label>
                                              <select class="ui fluid dropdown" name="cod_cat" id="categoria" required>
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
                            <input type='file' name='foto_produto' placeholder="Escolha uma imagem"/>
                        </div>
                        <?php

                        if (isset($_GET['u']) and $_GET['u'] == 2) {
                            echo '<p>Escolha uma imagem menor</p>';

                        } elseif (isset($_GET['u']) and $_GET['u'] != 'e') {
                            echo '<p>" ' . $_GET['u'] . ' " não é um arquivo suportado</p>';
                        }

                        ?>

                        <button type="submit" class="ui fluid large teal submit button bg_secundario"
                                name="cadastrar_produto">Cadastrar
                        </button>
                    </div>

                </form>
            </div>
            <div class="column footerM"></div>
        </div>


        </div>
        </div>
        </div>
        </body>
        <?php
        include "footer.php";
    }else{
        header('location: mercado_login.php');
    }