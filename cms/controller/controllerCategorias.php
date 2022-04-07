<?php
/*Responsável pela manipulação dos dados das Categorias.
Todas as validações desses dados devem ser feitas neste arquivo antes de
serem enviados ao arquivo Moodel.*/

require_once('model/bd/modelCategorias.php');

    function listarCategorias(){
        
        /*Executando função do arquivo model que retorna as 
        categorias que existem no Data Base.*/
        $dados = selectAllCategorias();

        /*Verificando se houve retorno do Data Base e o retornando ao 
        arquivo que chamou a controller (categorias.php). */
        if(!empty($dados)){
            return $dados;
        }else{
            return false;
        }
    }

    function excluirCategorias(){

    }

    function inserirCategorias($dadosCategoria){

        /*Verificando se chegaram dados.*/
        if(!empty($dadosCategoria)){

            /*Verificando se o campo obrigatório 'nome' está preenchido.*/
            if(!empty($dadosCategoria['txtNome'])){

                $arrayDados = array(
                        "nome" => $dadosCategoria['nome']
                );

                if(insertCategoria($dadosCategoria)){
                    return true;
                
                }else{
                    return array('idErro' => 1,
                                'message' => 'Não foi possível inserir os dados no Data Base.');
                }
            
            }else{
                return array('idErro' => 2,
                            'message' => 'Existem campos obrigatórios que não foram preenchidos.');
            }
        }

    }
?>