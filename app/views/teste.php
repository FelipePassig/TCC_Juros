<?php
session_start();
require __DIR__.'/cabecalho.php';
require __DIR__.'/cabecalho_geral.php';
require __DIR__.'/../controllers/busca.php';
?>

<div>
<form method="POST" id="form-pesquisa" action="">
    Pesquisar: <input type="text" name="pesquisa" id="pesquisa" placeholder="O que você está procurando?">
    <input type="submit" name="enviar" value="Pesquisar">
</form>
</div>
<div>
<ul class="resultado"></ul>
</div>