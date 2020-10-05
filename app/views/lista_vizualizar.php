<?php
session_start();
require __DIR__.'/cabecalho_geral.php';
require __DIR__.'/../controllers/lista.php';
$cod_lista = $_POST['cod_lista'];
$cnpj = $_POST['cnpj'];
$imposto = $_POST['imposto'];
$aux = dados_lista($cod_lista);
?>
            <div class="ui width grid">
                 <div class="five wide column ">

                 </div>
                 <div class="six wide column">
                    <div class="ui horizontal divider cor_tercearia">
                        <?=$aux['nome_lista']?>
                    </div>
                    <div class="ui cor_tercearia">
                       Valor total R$<?=$aux['valor_lista']?>
                    </div>
                    <div class="ui cor_tercearia">
                       Valor total pago de impostos R$<?=$imposto?>
                    </div>
    <?php
        foreach ($aux['produtos'] as $produto) {
           $valor_imposto = ($produto['percent_preco']*$produto['preco_prod'])/100;
            ?>
                <div class="ui divided items">
                    <div class="item">
                         <div class="image">
                                   <img src="../../imagens/foto_produto/<?=$produto['foto_produto']?>">
                         </div>
                         <div class="content">
                               <div class="header"><?=$produto['nome_produto']?></div>
                             <div class="meta">
                                   <span class="cinema">Preço : R$ <?=$produto['preco_prod']?></span>
                               </div>
                               <div class="meta">
                                   <span class="cinema">Preço pago de impostos : R$ <?=$valor_imposto?></span>
                               </div>
                                <div class="meta">
                                   <span class="cinema">Descrição: <?=$produto['desc_prod']?></span>
                               </div>
                                <div class="meta">
                                  <span class="cinema">Peso Liq. : <?=$produto['peso_liq']?></span>
                               </div>
                              <div class="meta">
                                    <span class="cinema">Marca: <?=$produto['marca']?></span>
                               </div>
                               <div class="meta">
                                   <span class="cinema">Quantidade: <?=$produto['qtd_item_lista']?></span>
                                </div>
                                 <form action= "../controllers/lista.php?acao=excluir_item" method="post">
                                        <button name="cod_produto" value="<?=$produto['cod_produto']?>" class="ui button red">Excluir</button>
                                        <input type="hidden" name="cod_lista" value="<?=$cod_lista?>">
                                        <input type="hidden" name="preco_item" value="<?=$produto['preco_prod']?>">
                                        <input type="hidden" name="qtd_item" value="<?=$produto['qtd_item_lista']?>">
                                        <input type="hidden" name="valor_lista" value="<?=$aux['valor_lista']?>">
                                 </form>
                         </div>
                    </div>
                </div>
            <?php
        }
        ?>
        <div class="ui divider"></div>
                </div>

    <div class="five wide column ">
        <form action="lista_np.php" method="post">
            <button  class="ui button rigth green descer" value="<?=$cod_lista?>" name="cod_lista">+ Novo Produto</button>
            <input type="hidden" value="<?=$cnpj?>" name="cnpj">
        </form>
    </div>
            </div>
</div>

            <?php
//            include "footer.php";
    ?>


