<?php
session_start();
require __DIR__.'/../views/cabecalho_geral.php';
$cod_prod = $_GET['cod'];
echo '
<div class="ui width grid">
	<div class="one wide column "></div>
	<div class="fourteen wide column">
		<div class="ui middle aligned divided list marginUsu">
			<div class="ui horizontal divider cor_tercearia">
				exclusão de produtos
			</div>
			<a href="../views/mercado_paginaLog.php">
                                <button class="ui button green" id="editar_produto">Cancelar</button>
                            </a>
                            <a href="../controllers/produto.php?acao=produto_delete&&cod='.$cod_prod.'">
                                <button class="ui button red">Excluir</button>
                            </a>
		</div>
	</div>
</div>
';