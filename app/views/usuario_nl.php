<?php
session_start();
include "cabecalho_geral.php";
require __DIR__.'/../controllers/usuario.php';
if (isset($_SESSION['logado']) and $_SESSION['logado'] =='sim'){
  ?>
  <script>

   $(document).ready(function () {

     $("#uf").on("change", function () {
      var cod_uf = $("#uf").val();
      $('#cidades').empty();
      $('#bairros').empty();
      $('#mercados').empty();

      $.ajax({
        url: '../controllers/mercado_select_cidade.php',
        method: 'post',
        dataType: "json",
        data: {cod_uf: cod_uf},
        success: function (data, textStatus, jQxhr) {
          $("#cidades").append('<option value="0">Cidade</option>');
          $("#bairros").append('<option value="0">Bairro</option>');
          $("#mercados").append('<option value="0">Mercado</option>');
          for (i = 0; i < data.length; i++) {
              //console.log(data[i]['nome_cidade']);
              var cod = data[i]['cod_cidade'];
              var nome = data[i]['nome_cidade'];
              $("#cidades").append('<option value="' + cod + '">' + nome + '</option>');
            }
          },
          error: function (jqXhr, textStatus, errorThrown) {
              // console.log(errorThrown);
              $("#cidades").append('<option value="0">Cidade</option>');
              $("#bairros").append('<option value="0">Bairro</option>');
              $("#mercados").append('<option value="0">Mercado</option>');
            }
          });
    });

     $("#cidades").on("change", function () {
       var cod_cidade = $("#cidades").val();
             //console.log(cod_cidade);

             $('#bairros').empty();
             $('#mercados').empty();
             $.ajax({
               url: '../controllers/mercado_select_bairro.php',
               method: 'post',
               dataType: "json",
               data: {cod_cidade: cod_cidade},
               success: function (data, textStatus, jQxhr) {
                 $("#bairros").append('<option value="0">Bairro</option>');
                 $("#mercados").append('<option value="0">Mercado</option>');
                 for (i = 0; i < data.length; i++) {
                         //console.log(data[i]['nome_bairro']);
                         var cod = data[i]['cod_bairro'];
                         var nome = data[i]['nome_bairro'];
                         $("#bairros").append('<option value="' + cod + '">' + nome + '</option>');
                       }
                     },
                     error: function (jqXhr, textStatus, errorThrown) {
                     // console.log(errorThrown);
                   }
                 });
           });

     $("#bairros").on("change", function () {
       var cod_bairro = $("#bairros").val();
             //console.log(cod_bairro);

             $('#mercados').empty();
             $.ajax({
               url: '../controllers/mercado_select_mercado.php',
               method: 'post',
               dataType: "json",
               data: {cod_bairro: cod_bairro},
               success: function (data, textStatus, jQxhr) {
                 $("#mercados").append('<option value="0">Mercado</option>');
                 for (i = 0; i < data.length; i++) {
                         //console.log(data[i]['nome_mercado']);
                         var cnpj = data[i]['cnpj'];
                         var nome = data[i]['nome_mercado'];
                         $("#mercados").append('<option value="' + cnpj + '">' + nome + '</option>');
                       }
                     },
                     error: function (jqXhr, textStatus, errorThrown) {
                     // console.log(errorThrown);
                   }
                 });
           });
     $("#mercados").on("change", function () {
       var cod_mercado = $("#mercados").val();
             // console.log(cod_mercado);

             $.ajax({
               url: '../controllers/mercado_select_produto.php',
               method: 'post',
               dataType: "json",
               data: {cod_mercado: cod_mercado},
               success: function (data, textStatus, jQxhr) {
                     // console.log(data);
                     $("#cardx").empty();
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
                       var percent_preco = (data[i]['percent_preco'] * data[i]['preco_prod'])/100 ;



                       $("#cardx").append(


                        '<div class="five wide column">' +
                        '<div class="ui card top Cardsss nl">'+
                        
                        '<div class="ui image medium">'+ 
                        '<img src="../../imagens/foto_produto/' + foto_produto + '">'+ 
                        '</div>'+
                        '<div class="content">'+
                        '<div class="header">' + nome_produto + '</div>'+
                        '</div>'+
                        
                        '<div class="content">'+
                        '<p class="ui sub header">Preço: R$ ' + preco_prod + '</p>'+
                        '<p class="ui sub header">Preço pago de impostos: R$ ' + percent_preco + '</p>'+
                        '<p class="ui sub header">Peso: ' + peso_liq + '</p>'+
                        '<p class="ui sub header">Marca: ' + marca + '</p>'+
                        '<p class="ui sub header">Descrição: ' + desc_prod + '</p>'+
                        '</div>'+
                           ' <input type="number" class="ss" name="qtd_item_' + cod_produto + '" value="1" max = "100" min="1" required title="Escolha uma quantidade de produtos que deseja" />' +
                            '<div class="extra content">' +
                                 '<div class="ui button troca" id="' + cod_produto + '">Adicionar</div>' +
                                 '</div>' +
                                 ' <input type="hidden" value="0" id="input' +cod_produto + '" name="cod_' + cod_produto + '"/>' +
                           ' <input type="hidden" value="'+ cnpj_prod +'" name="cnpj_prod"/>' +
                        

                        '</div>'+
                        '</div>'


                        );
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
           });



})

</script>

<form method="post" action="../controllers/lista.php?acao=salvar_lista">
 <div class="ui width grid">
  <div class="one wide column "></div>
  <div class="fourteen wide column">

   <div class="margin criarNovaLista">
    <center><h1>Criando Nova Lista</h1>
     <p>Dê um nome a sua lista</p>
     <div class="ui input">
      <input type="text" placeholder="Nome da lista" name="nome_lista" required="Por favor coloque o nome da sua lista">
    </div>
    <p></p>
    <p>Selecione todos os produtos que você deseja adicionar a lista, clicando no botão depois salve-a clicando em "Finalizar".</p></center>
  </div>

  <div class=" margin">
   <div class="ui horizontal divider"> 
    adicione produtos
  </div>
</div>

<div class="ui floating labeled icon dropdown button drop direita">

  <div class="two fields">
    <div class="eight wide field">
      <label>UF</label>
      <select class="ui fluid dropdown"  name="uf" id="uf" title="Selecione seu estado">
        <option value="">UF</option>
        <?php
        $conexaos = new Connection();
        $recebeConexao = $conexaos->conectar();
        $sql_uf = "select * from uf ";
        $uf = $recebeConexao->query($sql_uf)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($uf as $estados) {
          echo '<option value="' . $estados['cod_uf'] . '">' . $estados['nome_uf'] . '</option>';
        }
        ?>
      </select>
    </div>

    <div class="field">
      <label>Cidade</label>
      <select name="cidade" id="cidades" class="ui fluid dropdown"
      title="Selecione sua cidade">
      <option value="">Cidade</option>
    </select>
  </div>
</div>

<div class="fields">

  <div class="eight wide field">
    <label>Bairro</label>
    <select name="bairro" id="bairros" class="ui fluid dropdown"
    title="Selecione seu bairro">
    <option value="">Bairro</option>
  </select>
</div>

<div class="eight wide field">
  <label>Mercado</label>
  <select name="mercado" id="mercados" class="ui fluid dropdown"
  title="Selecione seu mercado">
  <option value="">Mercado</option>
</select>
</div>
</div>
</div>

</div>
</div>
</div>
</div>

<div class="ui grid">
  <div class="sixteen wide column"></div>
</div>

<div class="ui grid" id="cardx">


</div>


<center><input type="submit" class="ui  large teal submit button bg_secundario final" name="lista_finalizada" value="Finalizar"></center>
<div class="one wide column "></div>
</div>
</div>
</form>
<?php 
include "footer.php"; 
}else{
	header('location: ../views/usuario_login.php');
}
?>