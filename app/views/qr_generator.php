<?php
session_start();
require __DIR__.'/cabecalho.php';
require __DIR__.'/cabecalho_geral.php';
$conteudo = $_POST["cod_prod"];

$nome_produto = $_POST['nome_produto'];
$nome_produto_r = str_replace(' ','_',$nome_produto);
?>
<a href="" id="qr_download" download="<?=$nome_produto_r?>">
    <div id="qrcode"  title="baixar imagem" class="marginUSu centralll" ></div>
</a>
<script src="qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById('qrcode'), {
        text: '<?=$conteudo?>',
        width: 300,
        height:300,
        colorDark: '#000000',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });

    $(document).ready(function () {
        var caminho = $('#qr_download img').attr("src");
        console.log(caminho);
        $("#qr_download").attr("href", caminho);
    });
</script>
<a href="mercado_paginaLog.php">
    <div class="ui left floated button blue centrallll">Voltar</div>
</a>

