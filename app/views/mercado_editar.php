<?php
session_start();
require __DIR__.'/../controllers/usuario.php';
  if (isset($_SESSION['mercado']['logado']) and $_SESSION['mercado']['logado'] == "sim") {
    require __DIR__.'/cabecalho_geral.php';
    ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
        $(document).ready(function () {
            var $seuCampotelefone = $("#telefone_mercado");
            $seuCampotelefone.mask('(00)000000000', {reverse: false});
            var $seuCampocep = $("#cep");
            $seuCampocep.mask('00000-000', {reverse: false});
            
            $("#uf").on("change", function () {
                var cod_uf = $("#uf").val();
                $('#cidades').empty();
                $.ajax({
                    url: '../controllers/mercado_select_cidade.php',
                    method: 'post',
                    dataType: "json",
                    data: {cod_uf: cod_uf},
                    success: function (data, textStatus, jQxhr) {
                        $("#cidades").append('<option value="0">Cidade</option>');
                        for (i = 0; i < data.length; i++) {
                            console.log(data[i]['nome_cidade']);
                            var cod = data[i]['cod_cidade'];
                            var nome = data[i]['nome_cidade'];
                            $("#cidades").append('<option value="' + cod + '">' + nome + '</option>');
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            });

            $("#cidades").on("change", function () {
                var cod_cidade = $("#cidades").val();
                console.log(cod_cidade);

                $('#bairros').empty();
                $.ajax({
                    url: '../controllers/mercado_select_bairro.php',
                    method: 'post',
                    dataType: "json",
                    data: {cod_cidade: cod_cidade},
                    success: function (data, textStatus, jQxhr) {
                        $("#bairros").append('<option value="0">Bairro</option>');
                        for (i = 0; i < data.length; i++) {
                            console.log(data[i]['nome_bairro']);
                            var cod = data[i]['cod_bairro'];
                            var nome = data[i]['nome_bairro'];
                            $("#bairros").append('<option value="' + cod + '">' + nome + '</option>');
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            });

        })
    </script>
    <div class="ui mobile reversed equal width grid">
      <div class="column"></div>
      <div class="column">

        <div class="marginCad">
            <h1>
                <div class="ui horizontal divider">
                    Editar Mercado  
                </div>
            </h1>
        </div>

        <form class="ui large form" method="post" action="../controllers/mercado.php?acao=mercado_editar">
            <div class="ui stacked segment">

                <div class="field">
                    <label>Nome Mercado</label>
                    <input name="nome_mercado_editar" id="nome_mercado" type="text" value="<?php echo $_SESSION['mercado']['nome_mercado'] ?>" required>
                </div>

                <div class="field">
                    <label>Telefone</label>
                    <input name="telefone_mercado_editar" id="telefone_mercado" type="text" value="<?php echo $_SESSION['mercado']['telefone_mercado'] ?>" required>
                </div>

                <div class="field">
                    <label>E-mail</label>
                    <input name="email_mercado_editar" id="email_mercado" type="text" value="<?php echo $_SESSION['mercado']['email_mercado'] ?>" required>
                </div>

                <div class="two fields">
                        <div class="eight wide field">
                            <label>UF</label>
                            <select class="ui fluid dropdown" required name="uf_editar" id="uf" title="Selecione seu estado">
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
                            <select name="cidade_editar" id="cidades" class="ui fluid dropdown" required
                                    title="Selecione sua cidade">
                                <option value="">Cidade</option>
                            </select>
                        </div>
                    </div>

                <div class="fields">

                    <div class="eight wide field">
                        <label>Bairro</label>
                        <select name="bairro_editar" id="bairros" class="ui fluid dropdown" required
                        title="Selecione seu bairro">
                        <option value="">Bairro</option>
                    </select>
                </div>

                <div class="field">
                    <label>Rua</label>
                    <input placeholder="Ex.: Das Palmeiras" type="text" name="rua_editar" required
                    title="Prencha com o nome de sua rua" value="<?php echo $_SESSION['end']['rua'] ?>">
                </div>

                <div class="eight wide field">
                    <label>Numero</label>
                    <input type="number" placeholder="Ex.: 365" name="numero_editar" required min="0" max="9999" title="Prencha com seu número de residência" value="<?php echo $_SESSION['end']['numero'] ?>">
                </div>

            </div>

            <div class="fields">
                        <div class="sixteen wide field">
                            <label>CEP</label>
                            <input type="text" placeholder="Ex.: ****-**" name="cep_editar" id="cep" require value="<?php echo $_SESSION['end']['cep'] ?>" title="Prencha com seu CEP">
                        </div>
                    </div>

            <div class="field">
                <label>Senha</label>
                <input name="senha_mercado_editar" id="senha_mercado" placeholder="Nova senha" type="password" required>
            </div>

                <a href="../controllers/mercado.php?acao=mercado_delete">
                <div class="tiny ui basic button negative right floated del" id="c">
                  Deletar conta
                </div>
                </a>

            <button type="submit" class="ui fluid large teal submit button bg_secundario" name="editar_mercado">Atualizar</button>
        </div>
    </form>
    
</div>
<div class="column"></div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>



</body>
<?php
require __DIR__.'/footer.php';
}else{
    index();
}