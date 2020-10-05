<?php
session_start();
include "cabecalho_geral.php";
require __DIR__.'/../controllers/usuario.php';
if (isset($_SESSION['logado']) and $_SESSION['logado'] =='sim'){

    ?>

    <form id="form" method="post" action="../controllers/lista.php?acao=lista_qr">
        <div class="ui width grid">
            <div class="one wide column "></div>
            <div class="fourteen wide column">
                <?php
                if (isset($GET['error']) and $_GET['error'] == 'produto'){
                    echo '<script>alert("Você precisa adicionar no minímo um produto");</script>';
                }
                ?>
                <div class="margin criarNovaLista">
                    <center><h1>Criando Nova Lista</h1>
                        <p>Escaneie todos os produtos que você deseja adicionar a lista, clicando no botão depois salve-a clicando em "Finalizar".</p>
                    </center>
                </div>

                <div class=" margin">
                    <div class="ui horizontal divider">
                        adicione produtos
                    </div>
                </div>


                <video id="preview" class="centrall"></video>

                <div class="botoess">
                    <input v-if="displaynone" type="button" @click="fetchProd" class="ui  large teal submit button ui primary basic bg_secundario " name="add_prod" value="Adicionar">
                    <input v-if="displaynone" type="number" id="qtd" name="qtd_item" class="adicionarqr2" v-model="qtd_item" max = "100" min="1" title="Escolha uma quantidade de produtos que deseja" required="Você precisa adicionar um produto no minímo" />
                </div>
                <br>
                <br>
                <br>
                <br>

        <input type="submit"  class="ui fluid large green submit button  green finalizarqr" name="lista_finalizada" value="Finalizar">
        <div class="one wide column "></div>
        </div>
        </div>
    </form>

    <script>

        let form = new Vue({
            el: '#form',
            data: {
                qtd_item: 1,
                scaner: null,
                content: null,
                displaynone: false
            },
            mounted() {
                this.startScan()
            },
            methods: {
                addProd(content) {
                    alert('Um produto foi escaneado');
                    this.content = content
                    this.displaynone = true

                    alert('Agora selecione a quantidade de produtos que deseja e clique em continuar');
                },
                fetchProd() {
                    let formData = new FormData();
                    formData.append('cod_produto', this.content);
                    formData.append('qtd_item', this.qtd_item);

                    fetch("../controllers/lista.php?acao=lista_qr&cod_produto="+this.content+"&qtd_item="+this.qtd_item, {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        method: "GET"
                    }).then(function(res){
                        console.log(res)
                        alert('O produto foi adicionado')
                        form.resetQtd()
                        form.displaynone = false
                    }).catch(function(error) {
                        // console.log('There has been a problem with your fetch operation: ' + error.message);
                    })
                },
                startScan() {
                    this.scaner = new Instascan.Scanner({ video: document.getElementById('preview') });
                    Instascan.Camera.getCameras().then(cameras => {
                        this.scaner.camera = cameras[cameras.length - 1];
                        this.scaner.start();
                    }).catch(console.error);

                    this.scaner.addListener('scan', content => {
                        this.addProd(content)
                    })
                },
                resetQtd() {
                    this.qtd_item = 1
                }
            }
        })
    </script>
    <?php
//include "footer.php";
}else{
    header('location: ../views/usuario_login.php');
}
?>














