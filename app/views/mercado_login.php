<?php
session_start();

    if (!isset($_SESSION['mercado']['logado']) or $_SESSION['mercado']['logado'] == 'nao') {
        require __DIR__ . '/cabecalho_geral.php';
        ?>
        <body>

        <div class="ui mobile reversed equal width grid">
            <div class="column"></div>
            <div class="column">

                <div class="marginLog">
                    <h2>
                        <div class="ui horizontal divider">
                            Login de mercado
                        </div>
                    </h2>
                </div>

                <form class="ui large form" method="post" action="../controllers/mercado.php?acao=mercado_login">
                    <div class="ui stacked segment">
                        <div class="field">
                            <?php
                            if (isset($_GET['error']) and $_GET['error'] == 'email_mercado') {
                                echo '<div class="ui horizontal redd">Email incorreto ou inexistente</div>';
                            }
                            ?>
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                <input type="text" name="email_login_mercado" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="field">
                            <?php
                            if (isset($_GET['error']) and $_GET['error'] == 'senha_mercado') {
                                echo '<div class="ui horizontal redd">Senha incorreta</div>';
                            }
                            ?>
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="senha_login_mercado" placeholder="Senha">
                            </div>
                        </div>
                        <button class="ui fluid large teal submit button bg_secundario" name="entrar_mercado">Entrar
                        </button>
                    </div>
                </form>

                <center>
                    <div class="ui message">
                        Seu mercado ainda não é participante? <a href="mercado_cadastro.php">Cadastre aqui</a>
                    </div>
                </center>
            </div>
            <div class="column"></div>
        </div>


        </body>
        <?php
        include "footer.php";
    }else{
        header('location: ../views/mercado_paginaLog.php');
    }
        ?>