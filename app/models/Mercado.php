<?php

class Mercado{

    //ATRIBUTOS DA CLASSE
    public $nome_mercado;
    public $cnpj;
    public $senha_mercado;
    public $ie;
    public $email_mercado;
    public $telefone_mercado;
    public $rua;
    public $numero;
    public $cep;
    public $foto_mercado;
    public $tipoUsuario;

    public $conexao_mercado;

    public function __construct(){
        $this->tipoUsuario = 3;
        $conexao_objeto = new Connection();
        $this->conexao_mercado = $conexao_objeto->conectar();
    }
//        insere na tab mercado
    public function salvar_mercado($nome_mercado, $senha_mercado, $cnpj, $ie, $email_mercado, $telefone_mercado, $rua, $numero, $cep, $bairro,$cidade,$uf,$foto_mercado){

        $sql_mercado = "insert into mercado(nome_mercado, senha_mercado, cnpj, ie, email_mercado, telefone_mercado, cod_tip_usu_cod, foto_mercado) values ('{$nome_mercado}', '{$senha_mercado}', '{$cnpj}', '{$ie}', '{$email_mercado}', '{$telefone_mercado}', 3, '{$foto_mercado}');";
        $this->conexao_mercado->exec($sql_mercado);

//        insere na tab endereco

        $sql_mercado_endereco = "insert into endereco(rua, numero, cod_bairro_cod, cnpj_end,cod_tipo_end_cod, cep) values ('{$rua}', {$numero}, {$bairro}, '{$cnpj}', '2', '{$cep}');";
        $this->conexao_mercado->exec($sql_mercado_endereco);


    }

    public function valida_foto($foto_mercado){

        if ($foto_mercado['type'] == 'image/png' or $foto_mercado['type'] == 'image/jpeg' ){

            if ($foto_mercado['size'] > 400000000000){
                return 2; //ESCOLHA UMA IMAGEM MENOR
            }else{
                return 1; //IMAGEM VALIDA
            }

        }elseif ($foto_mercado['type'] == 'image/jpg'){

            if ($foto_mercado['size'] > 400000000000){
                return 2; //ESCOLHA UMA IMAGEM MENOR
            }else{
                return 1; //IMAGEM VALIDA
            }

        }elseif (empty($foto_mercado['name'])){
            return 4; //SEM IMAGEM
        }else{
            $nome = explode('.', $foto_mercado['name']);
            return $nome[1]; //ESCOLHA UMA IMAGEM VALIDA
        }

    }

    public function editar_mercado($nome_mercado, $telefone, $email, $senha, $cnpj,$bairro,$cidade,$uf,$cep,$numero,$rua){
        $sql_editar_endereco = "update endereco set rua = '{$rua}', numero = '{$numero}', cod_bairro_cod = '{$bairro}', cep = '{$cep}', cidade = '{$cidade}', uf = '{$uf}' where cnpj_end = '{$cnpj}';";
        $this->conexao_mercado->exec($sql_editar_endereco);

        $sql_editar = "update mercado set nome_mercado='{$nome_mercado}', email_mercado='{$email}', senha_mercado='{$senha}', telefone_mercado = '{$telefone}', foto_mercado = '{$nome_foto_mercado}' WHERE cnpj = '{$cnpj}'";
        $this->conexao_mercado->exec($sql_editar);

        $_SESSION['mercado']['nome_mercado'] = $nome_mercado;
        $_SESSION['mercado']['telefone_mercado'] = $telefone;
        $_SESSION['mercado']['email_mercado'] = $email;
        $_SESSION['mercado']['senha_mercado'] = $senha;
        $_SESSION['mercado']['rua'] = $rua;
        $_SESSION['mercado']['numero'] = $numero;
        $_SESSION['mercado']['cep'] = $cep;
    }


    public function deletar_mercado($cnpj){
        $sql_delete_endereco = "delete from endereco where cnpj_end = '{$cnpj}';";
        $this->conexao_mercado->exec($sql_delete_endereco);

        $sql_delete = "delete from mercado where cnpj = '{$cnpj}';";
        $this->conexao_mercado->exec($sql_delete);
    }
}