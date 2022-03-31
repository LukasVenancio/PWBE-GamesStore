<?php
/*Responsável pela manipulação de dados de contatos.
Todos os tratamentos e validações precisam ser feitos no arquivo controller. */


/*Quando fazemos um require, o fazemos da página que está aberta no navegador, e não de fato da página onde está o require. */
require_once('model/bd/modelContatos.php');

function listarContatos(){

    /*Função da model que retorna a lista de contatos do db. */
    $dados = selectAllContatos();

    if(!empty($dados)){
        return $dados;
    }else{
        return false;
    }
}


?>