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

function excluirContato($id){
    
    /*Validação do id que foi informado. */
    if($id != 0 && !empty($id) && is_numeric($id)){

        /*Verificando se foi possível deletar o contato.*/
        if(deleteContato($id)){
            return true;
        
        }else{
            return array('idErro' => 3,
                        'message' => 'O Data Base não pôde excluir o registro.');
        }
        
    }else{
        return array('idErro' => 4,
                    'message' => 'ID inválido.');
    }
}


?>