<?php
session_start();
require __DIR__."/cabecalho.php";
require __DIR__."/../controllers/mercado.php";
$todos_mercados = todos_mercados();
?>
<body class="pushable">

    <!-- MENU ROLAGEM -->
    <div class="ui large  fixed menu transition hidden">
        <div class="ui container">
            <a class=" item" href="../views/home.php">Home</a>
            <a class="item" href="mercado_pagina.php">Mercados</a>
            <?php
            if (!isset($_SESSION['cpf'])) {
                if (isset($_SESSION["mercado"]["logado"]) and $_SESSION["mercado"]["logado"] == "sim") {
                    echo '
                <a href="../views/mercado_paginaLog.php">
                    <div class="ui left item">
                        '.$_SESSION["mercado"]["nome_mercado"].'
                    </div>
                </a>
';
                }
                echo '    
                <div class="right menu">
                <div class="item">
                <a class="ui" href="usuario_login.php">Login</a>
                </div>
                <div class="item">
                <a class="ui" href="../views/usuario_cadastro.php">Cadastro</a>
                </div>
                </div>
                ';
            }else{
            if (isset($_SESSION["logado"]) and $_SESSION["logado"] == "sim") {
                echo '<div class="item right">
                    <i class="user outline icon"></i>
                </div>
                <a href="../views/usuario_pagina.php">
                    <div class="item">
                        '.$_SESSION["primeiro_nome"].'
                    </div>
                </a>
                ';}
                if (isset($_SESSION["mercado"]["logado"]) and $_SESSION["mercado"]["logado"] == "sim") {
                    echo '
                <a href="../views/mercado_paginaLog.php">
                    <div class="item">
                        '.$_SESSION["mercado"]["nome_mercado"].'
                    </div>
                </a>
';

            }
                            echo '
                <div class="right menu">
                <div class="item">
                <a class="ui" href="../controllers/usuario.php?acao=usuario_deslogar">Deslogar</a>
                </div>
                <div class="item">
                <a class="ui" href="../views/usuario_pagina.php">Minha Página</a>
                </div>
                </div>';
            }

            ?>
        </div>
    </div> 

    <!-- Page Contents -->
    <div class="pusher">

        <div class="ui inverted vertical masthead center aligned segment bg_primarioIndex ">
            <div class="ui text container letraIndex">
                <h1 class="ui inverted header">QrList</h1>
                <h2>Um jeito inovador de fazer suas listas de compras.</h2>
                <div class="item ">
                    <?php if (!isset($_SESSION['cpf'])) :?>
                        <a class="ui inverted button" href="../views/usuario_login.php">Login</a>
                        <a class="ui inverted button" href="../views/usuario_cadastro.php">Cadastro</a>
                        <?php else: ?>
                         <a class="ui inverted button" href="../controllers/usuario.php?acao=usuario_deslogar">Deslogar</a>
                     <?php endif; ?>
                 </div>
             </div>
         </div>

         <div class="ui vertical stripe segment fundoIndex" id="listaNormal">
            <div class="ui middle aligned stackable grid container espacamento">
                <div class="row">
                    <div class="eight wide column">
                        <h3 class="ui header cor_secundaria">FAÇA SUAS LISTAS DE COMPRAS ONLINE!</h3>
                        <p>O QrList é um site que possibilita a confecção de suas listas de compras de forma online e inteiramente gratuita! Você pode fazer sua lista de duas formas: craindo normalmente pelo site ou pelo QrCode!</p>
                        <h3 class="ui header cor_secundaria">COMO FAZER UMA LISTA DE COMPRAS PELO SITE NORMALMENTE?</h3>
                        <ul class="ui list">
                            <li><p> Faça o login, depois clique no botão "Nova Lista" e dê nome a sua lista</p></li>
                            <li><p> Depois você pode escolher o mercado que deseja ver os produtos para adicionar.</p></li>
                            <li><p> E apartir daí é só adicionar os produtos em sua lista!</p></li>
                            <li><p> Quando terminar de adicionar todos os produtos desejados, é só clicar em "Finalizar", e prontinho, lista criada! </p></li>
                        </ul>                       
                    </div>
                    <div class="six wide right floated column">
                        <img src="../../imagens/listaaa.png" class="ui Medium bordered rounded image">
                    </div>
                </div>
            </div>
        </div>

        <div class="ui vertical stripe segment fundoIndex" id="listaQr">
            <div class="ui middle aligned stackable grid container espacamento">
                <div class="row">
                    <div class="six wide left floated column">
                        <img src="../../imagens/qrcode.png" class="ui Medium bordered rounded image">
                    </div>
                    <div class="eight wide column">
                        <h3 class="ui header cor_secundaria ">COMO FAZER UMA LISTA DE COMPRAS PELO QRCODE?</h3>
                        <ul class="ui list">
                            <li><p> Faça o login, depois clique no botão "Nova Lista" e dê nome a sua lista</p></li>
                            <li><p> Depois você pode escolher o mercado que deseja ver os produtos para adicionar.</p></li>
                            <li><p> E apartir daí é só adicionar os produtos em sua lista!</p></li>
                            <li><p> Quando terminar de adicionar todos os produtos desejados, é só clicar em "Finalizar", e prontinho, lista criada! </p></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="ui vertical stripe segment fundoIndex">
            <div class="ui middle aligned stackable grid container espacamento">
                <div class="row">
                    <div class="eight wide column">
                        <h3 class="ui header cor_secundaria ">VÁRIAS OPÇÕES</h3>
                        <p>O QrList conta com <?php echo $todos_mercados['quantidade']; ?> mercados parceiros. Para ver quais estabelecimentos fazem parte desse grupo <a href="mercado_pagina.php">clique aqui</a>.</p>
                    </div>
                    <div class="six wide right floated column">
                        <img src="../../imagens/ligacao.png" class="ui Medium bordered rounded image">
                    </div>
                </div>
            </div>
        </div>

        <div class="ui vertical stripe segment fundoIndex">
            <div class="ui text container">
                <h3 class="ui header cor_secundaria" id="quemsomos">NOSSO OBJETIVO</h3>
                <p>Nosso objetivo principal é atender suas necessidades na hora de fazer uma lista de compra.</p>
                <p>Pensamos no seu conforto e comodidade para criar sua lista onde estiver e com todos os produtos e seus respectivos preços. Assim nossos usuários já saberão quais produtos comprar e quanto custurá!</p>
                <h4 class="ui horizontal header divider cor_tercearia">
                    NOSSA EQUIPE
                </h4>
                <h3 class="ui header cor_secundaria">QUEM SOMOS</h3>
                <p>Nossa equipe é composta por três estudantes do Instituto Federal Catarinense - Campus Araquari: Felipe Passig Coscodai, Leticia Helen de Sousa e Luiza Farias.</p>

                <div class="ui relaxed large horizontal list">
                  <div class="item">
                    <img class="ui avatar image" src="../../imagens/passig.jpg">
                    <div class="content">
                      <a href="https://www.instagram.com/felipe_passig/" class="header">Felipe Passig Coscodai</a>
                  </div>
              </div>
              <div class="item">
                <img class="ui avatar image" src="../../imagens/leticia.jpg">
                <div class="content">
                  <a href="https://www.instagram.com/lleticiasousa_/" class="header">Leticia Helen de Sousa</a>
              </div>
          </div>
          <div class="item">
            <img class="ui avatar image" src="../../imagens/luiza.jpg">
            <div class="content">
              <a href="https://www.instagram.com/lluizafarias/" class="header">Luiza Farias</a>
          </div>
      </div>
  </div>

</div>
</div>
<?php include "footer.php"  ?>