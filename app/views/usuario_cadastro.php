<?php
include "cabecalho_geral.php";
session_start();
if (!isset($_SESSION['logado']) or $_SESSION['logado'] == 'nao') {
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <body>
    <script>
        $(document).ready(function () {
            var $maskcpf = $("#cpf");
            $maskcpf.mask('000.000.000-00', {reverse: false});
            var $seuCampotelefone = $("#telefone");
            $seuCampotelefone.mask('(00)000000000', {reverse: false});
        })
    </script>
    <div class="ui mobile reversed equal width grid">
        <div class="column"></div>
        <div class="column">

            <div class="marginCad">
                <h1>
                    <div class="ui horizontal divider">
                        Criar Conta
                    </div>
                </h1>
            </div>

            <form class="ui large form" method="post" action="../controllers/usuario.php?acao=usuario_cadastro">
                <div class="ui stacked segment">

                    <div class="field">
                        <label>Primeiro nome</label>
                        <input name="primeiro_nome" id="primeiro_nome" type="text" placeholder="Ex: Ivo" required>
                    </div>

                    <div class="field">
                        <label>Sobrenome</label>
                        <input name="sobrenome" id="sobrenome" type="text" placeholder="Ex: Reigel" required>
                    </div>

                    <div class="field">
                        <?php
                        if (isset($_GET['error']) and $_GET['error'] == 'cpf') {
                            echo '<div class="ui horizontal red">Cpf ja cadastrado</div>';
                        }
                        ?>
                        <label>CPF</label>
                        <input name="cpf" id="cpf" type="text" placeholder="Ex: ***.***.***-**" required>
                    </div>

                    <div class="field">
                        <label>Telefone</label>
                        <input name="telefone" id="telefone" type="text" placeholder="Ex: (**)*******" required>
                    </div>

                    <div class="field">
                        <?php
                        if (isset($_GET['error']) and $_GET['error'] == 'email') {
                            echo '<div class="ui horizontal red">Email ja cadastrado</div>';
                        }
                        ?>
                        <label>E-mail</label>
                        <input name="email" id="email" type="text" placeholder="Ex: ivo_reigel@gmail.com" required>
                    </div>

                    <div class="field">
                        <label>Senha</label>
                        <input name="senha" id="senha" placeholder="Ex: ******" type="password" required>
                    </div>

                    <button type="submit" class="ui fluid large teal submit button bg_secundario" name="enviar">
                        Cadastrar
                    </button>
                </div>
            </form>
            <center>
                <div class="ui message">
                    Já tem uma conta? <a href="../views/usuario_login.php">Login</a>
                </div>
            </center>
        </div>
        <div class="column"></div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>

    </body>
    <?php
    include "footer.php";
}
?>