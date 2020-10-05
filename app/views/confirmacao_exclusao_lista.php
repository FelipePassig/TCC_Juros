<?php
session_start();
require __DIR__.'/../views/cabecalho_geral.php';
echo '
<div class="ui width grid">
	<div class="one wide column "></div>
	<div class="fourteen wide column">
		<div class="ui middle aligned divided list marginUsu">
			<div class="ui horizontal divider cor_tercearia">
				exclusão de listas
			</div>
			<a href="../views/usuario_pagina.php">
                    <button class="ui button green">Cancelar</button>
            </a>
            <form class="ladoladobot" action="../controllers/lista.php?acao=lista_delete" method="post">
                    <button class="ui button red" name="cod_lista" value="'.$_POST['cod_lista'].'">Excluir</button>
            </form>
		</div>
	</div>
</div>
';