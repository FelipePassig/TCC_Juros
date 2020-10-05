<?php
require __DIR__.'/cabecalho.php';
?>
<?php if (!isset($_SESSION['cpf'])) :?>
    <nav>
        <div class="ui inverted menu">
          <a class="active item" href="../views/home.php">
            Home
        </a>
        <a class="item" href="../views/usuario_login.php">
            Logar
        </a>
        <a class="item" href="../views/usuario_cadastro.php">
            Cadastrar
        </a>
        <?php
            if (isset($_SESSION['mercado']['logado']) and $_SESSION['mercado']['logado'] == 'sim') {
                ?>
                <a href="../views/mercado_paginaLog.php">
                    <div class="right item">
                        <?php
                        echo $_SESSION['mercado']['nome_mercado']
                        ?>
                    </div>
                </a>
                <?php
            }
            ?>
    </div>
</nav>
<?php else: ?>
    <nav>
        <div class="ui inverted menu">
            <a class="item" href="../views/home.php">
                Home
            </a>
            <?php
            if (isset($_SESSION['logado']) and $_SESSION['logado'] == 'sim') {
                ?>
                <div class="item right">
                    <i class="user outline icon"></i>
                </div>
                <a href="../views/usuario_pagina.php">
                    <div class="right item">
                        <?php
                        echo $_SESSION['primeiro_nome'];
                        ?>
                    </div>
                </a>
                <?php
            }
            if (isset($_SESSION['mercado']['logado']) and $_SESSION['mercado']['logado'] == 'sim') {
                ?>
                <a href="../views/mercado_paginaLog.php">
                    <div class="right item">
                        <?php
                        echo $_SESSION['mercado']['nome_mercado']
                        ?>
                    </div>
                </a>
                <?php
            }
            ?>
            <div class="right menu">
                <a href="../controllers/usuario.php?acao=usuario_deslogar" class="ui item">
                    Deslogar
                </a>
            </div>
        </div>
    </nav>
    <?php endif; ?>