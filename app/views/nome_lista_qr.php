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

        })

    </script>

    <form method="post" action="../controllers/lista.php?acao=nome_lista_qr">
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
                        <p>Dê nome a sua lista e clique em "Continuar" para prosseguir a adição de produtos.</p></center>
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
                            <select name="cidade" id="cidades" class="ui fluid dropdown direita"
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
        </div>

        <div class="">
            <div class="cardProduto">
                <div id="card">
                </div>

            </div>
        </div>
        <center><input type="submit" class="ui topp large teal submit button bg_secundario" name="continuar" value="Continuar"></center>
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