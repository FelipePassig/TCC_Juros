<?php
require __DIR__.'/../controllers/usuario.php';
if (isset($_SESSION['logado']) and $_SESSION['logado'] =='sim'){
    require __DIR__.'/cabecalho_geral.php';
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
        $(document).ready(function () {
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
                    Editar Usuário  
                </div>
            </h1>
        </div>

        <form class="ui large form" method="post" action="../controllers/usuario.php?acao=usuario_editar">
            <div class="ui stacked segment">

                <div class="field">
                    <label>Primeiro nome</label>
                    <input name="primeiro_nome_editar" id="primeiro_nome" type="text" value="<?php echo $_SESSION['primeiro_nome'] ?>" required>
                </div>

                <div class="field">
                    <label>Sobrenome</label>
                    <input name="sobrenome_editar" id="sobrenome" type="text" value="<?php echo $_SESSION['sobrenome'] ?>" required>
                </div>

                <div class="field">
                    <label>Telefone</label>
                    <input name="telefone_editar" id="telefone" type="text" value="<?php echo $_SESSION['telefone'] ?>" required>
                </div>

                <div class="field">
                    <label>E-mail</label>
                    <input name="email_editar" id="email" type="text" value="<?php echo $_SESSION['email'] ?>" required>
                </div>

                <div class="field">
                    <label>Senha</label>
                    <input name="senha_editar" id="senha" placeholder="Nova senha" type="password" required>
                </div>

                <a href="../controllers/usuario.php?acao=usuario_delete">
                <div class="tiny ui basic button negative right floated del" id="c">
                  Deletar conta
                </div>
                </a>
              <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
              <script>
                  $(document).ready(function () {

                    $( "#c" ).click(function() {
                      var desicao
                      var delete_usu = confirm( "Você tem certeza que deseja excluir sua conta?" );
                      if (delete_usu == true) {
                        decisao = 1;
                    } else {
                     desicao = 0; 
                    }
             })
         </script>

         <button type="submit" class="ui fluid large teal submit button bg_secundario" name="editar">Atualizar</button>
     </div>
 </form>

</div>
<div class="column"></div>
</div>
<br>
<br>
<br>



</body>
<?php
require __DIR__.'/footer.php';
}else{
    index();
}