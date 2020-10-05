<?php
session_start();
include "cabecalho_geral.php";
require __DIR__.'/../controllers/usuario.php';
if (isset($_SESSION['logado']) and $_SESSION['logado'] =='sim'){
    $cod_lista = $_POST['cod_lista'];
    $cnpj = $_POST['cnpj'];
    ?>
    <script>
        var cod_mercado = '<?=$cnpj?>';
        // console.log(JQuery.type(cod_mercado));

        $.ajax({
            url: '../controllers/mercado_select_produto.php',
            method: 'post',
            dataType: "json",
            data: {cod_mercado: cod_mercado},
            success: function (data, textStatus, jQxhr) {
                // console.log(data);
                $("#card").empty();
                for (i = 0; i < data.length; i++) {


                    var nome_produto = data[i]['nome_produto'];
                    var foto_produto = data[i]['foto_produto'];
                    var preco_prod = data[i]['preco_prod'];
                    var cod_produto = data[i]['cod_produto'];
                    var marca = data[i]['marca'];
                    var nome_cat = data[i]['nome_cat'];
                    var desc_prod = data[i]['desc_prod'];
                    var peso_liq = data[i]['peso_liq'];
                    var cnpj_prod = data[i]['cnpj_prod'];
                    var nome_mercado = data[i]['nome_mercado'];
                    var percent_preco = data[i]['percent_preco'];



                    $("#card").append(
                        '     <input type="hidden" value="'+ cnpj_prod +'" name="cnpj_prod">' +
                        '     <div class="ui card np" >' +
                        '     <div class="content">' +
                        '     <div class="header">' + nome_produto + '</div>' +
                        '     </div>' +
                        '     <div class="content">' +
                        '     <h4 class="ui sub header">categoria: ' + nome_cat + '</h4>' +
                        '     <br>' +
                        '     <img class="img_mercado" src="../../imagens/foto_produto/' + foto_produto + '">' +
                        '     <p></p>' +
                        '     <p class="ui sub header right floated">Valor: R$ ' + preco_prod + '</p>' +
                        '     <p class="ui sub header">Peso: ' + peso_liq + '</p>' +
                        '     <p class="ui sub header">Preço pago de impostos: R$ ' + percent_preco + '</p>'+
                        '     <p class="ui sub header">Marca: ' + marca + '</p>' +
                        '     <p class="ui sub header">Mercado: ' + nome_mercado + '</p>' +
                        '     <p class="ui sub header">Descrição: ' + desc_prod + '</p>' +
                        '     <div class="eight wide field">' +
                        '     <input type="number" class="" name="qtd_item_' + cod_produto + '" value="1" max = "100" min="1" required title="Escolha uma quantidade de produtos que deseja" />' +
                        '     </div>' +
                        '     </div>' +
                        '     <div class="extra content">' +
                        '     <div class="ui button troca" id="' + cod_produto + '">Adicionar</div>' +
                        '     <input type="hidden" value="0" id="input' +cod_produto + '" name="cod_' + cod_produto + '"/>' +
                        '     </div>' +
                        '     </div>');

                }
                $( ".troca" ).click(function(e) {
                    var id = e.target.id;
                    // console.log(id);
                    var value = $("#input"+id).val();
                    $('#'+id).toggleClass('green');
                    var texto = $("#"+id).text();
                    if (texto=="Adicionar") {
                        $('#'+id).text('Adicionado')
                        $("#input"+id).val(1);
                    }else{
                        $('#'+id).text('Adicionar')
                        $("#input"+id).val(0);
                    }
                });
            },
            error: function (jqXhr, textStatus, errorThrown) {
                // console.log(errorThrown);
            }
        });

    </script>

    <form method="post" action="../controllers/lista.php?acao=atualizar_lista">
        <div class="ui width grid">
            <div class="one wide column "></div>
            <div class="fourteen wide column">

                <div class="margin criarNovaLista">
                    <center><h1>Adicionar Novos Produtos</h1>
                        <p></p>
                        <p></p>
                        <p>Selecione todos os produtos que você deseja adicionar a lista, clicando no botão depois salve-a clicando em "Finalizar".</p></center>
                </div>

                <div class=" margin">
                    <div class="ui horizontal divider">
                        adicione produtos
                    </div>
                </div>


            </div>
        </div>

        <div class="ui grid">
            <div class="sixteen wide column"></div>
        </div>

        <div class="ui grid" id="card" >


        </div>
        <input type="hidden" name="cod_lista" value="<?=$cod_lista?>">
        <center><input type="submit" class="ui large teal submit button bg_secundario edit" name="lista_finalizada" value="Finalizar"></center>
        <div class="one wide column "></div>
        </div>
        </div>
    </form>
    <?php
//include "footer.php";
}else{
    header('location: ../views/usuario_login.php');
}
?>

