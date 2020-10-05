<?php
    session_start();
    require __DIR__.'/../controllers/usuario.php';
    require __DIR__ . '/cabecalho_geral.php';
    if (!isset($_SESSION['mercado']['logado']) or $_SESSION['mercado']['logado'] == 'nao') {
    ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
        $(document).ready(function () {

            var $maskcnpj = $("#cnpj");
            $maskcnpj.mask('00.000.000/0000.00', {reverse: false});
            var $seuCampotelefone = $("#telm");
            $seuCampotelefone.mask('(00)000000000', {reverse: false});
            var $seuCampoie = $("#ie");
            $seuCampoie.mask('000.000.000', {reverse: false});
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

    <body>

    <div class="ui mobile reversed equal width grid footerM">
        <div class="column footerM"></div>
        <div class="column footerM">

            <div class="marginCadM">
                <h1>
                    <div class="ui horizontal divider">
                        Cadastro de mercado
                    </div>
                </h1>
            </div>

            <form class="ui large form" method="post" action="../controllers/mercado.php?acao=mercado_cadastro" enctype='multipart/form-data'>
                <div class="ui stacked segment">

                    <div class="field">
                        <label>Nome do mercado</label>
                        <input type="text" placeholder="Ex.: Pague Menos" name="nome_mercado" required
                               title="Prencha com sua razão social">
                    </div>
                    <?php
                    if (isset($_GET['error']) and $_GET['error'] == 'cnpj') {
                        echo '<div class="ui horizontal red">Cnpj ja cadastrado</div>';
                    }
                    ?>
                    <div class="field">
                        <label>CNPJ</label>
                        <input type="text" placeholder="Ex.: **.***.***/****.**" name="cnpj" id="cnpj" required
                               title="Prencha com seu CNPJ">
                    </div>

                    <div class="field">
                        <label>Senha</label>
                        <input name="senha_mercado" id="senha" placeholder="Ex: ******" type="password" required
                               title="Prencha com sua senha">
                    </div>

                    <?php
                    if (isset($_GET['error']) and $_GET['error'] == 'ie') {
                        echo '<div class="ui horizontal red">Inscrição Estadual ja cadastrada</div>';
                    }
                    ?>
                    <div class="field">
                        <label>Inscrição Estadual</label>
                        <input type="text" placeholder="Ex.: ***.***.***" name="ie" id="ie" required
                               title="Prencha com sua IE">
                    </div>
                    <?php
                    if (isset($_GET['error']) and $_GET['error'] == 'email_mercado') {
                        echo '<div class="ui horizontal red">Email ja cadastrado</div>';
                    }
                    ?>
                    <div class="field">
                        <label>E-mail</label>
                        <input name="email_mercado" id="email" type="text" placeholder="Ex: ivo_reigel@gmail.com"
                               required title="Prencha com seu email">
                    </div>

                    <div class="field">
                        <label>Telefone</label>
                        <input type="text" placeholder="Ex.: (**) *********" name="telefone_mercado" id="telm" required
                               title="Prencha com seu telefone">
                    </div>
                    <div class="two fields">
                        <div class="eight wide field">
                            <label>UF</label>
                            <select class="ui fluid dropdown" required name="uf" id="uf" title="Selecione seu estado">
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
                            <select name="cidade" id="cidades" class="ui fluid dropdown" required
                                    title="Selecione sua cidade">
                                <option value="">Cidade</option>
                            </select>
                        </div>
                    </div>

                    <div class="fields">

                        <div class="eight wide field">
                            <label>Bairro</label>
                            <select name="bairro" id="bairros" class="ui fluid dropdown" required
                                    title="Selecione seu bairro">
                                <option value="">Bairro</option>
                            </select>
                        </div>

                        <div class="field">
                            <label>Rua</label>
                            <input placeholder="Ex.: Das Palmeiras" type="text" name="rua" required
                                   title="Prencha com o nome de sua rua">
                        </div>

                        <div class="eight wide field">
                            <label>Numero</label>
                            <input type="number" placeholder="Ex.: 365" name="numero" required min="0" max="9999"
                                   title="Prencha com seu número de residência">
                        </div>

                    </div>

                    <div class="fields">
                        <div class="sixteen wide field">
                            <label>CEP</label>
                            <input type="text" placeholder="Ex.: ****-**" name="cep" id="cep" required
                                   title="Prencha com seu CEP">
                        </div>
                    </div>

                    <div class="field">
                        <label>Foto do Mercado</label>
                        <input type='file' name='foto_mercado' placeholder="Escolha uma imagem" required="Por favor escolha uma imagem">
                    </div>
                    <?php

                    if (isset($_GET['u']) and $_GET['u'] == 2) {
                        echo '<p>Escolha uma imagem menor</p>';

                    } elseif (isset($_GET['u']) and $_GET['u'] != 'e') {
                        echo '<p>" ' . $_GET['u'] . ' " não é um arquivo suportado</p>';
                    }

                    ?>

                    <button type="submit" class="ui fluid large teal submit button bg_secundario"
                            name="cadastrar_mercado">Cadastrar
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

}else{
   header('location: ../views/mercado_paginaLog.php');
}
?>
