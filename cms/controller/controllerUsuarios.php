<?php

    require_once('model/bd/modelUsuarios.php');

    function listarUsuarios(){

        $dados = selectAllUsuarios();

        if(!empty($dados)){
            return $dados;
        }else{
            return false;
        }
        
    }

    function inserirUsuarios($dados){

        if(!empty($dados['txtNome']) && !empty($dados['txtLogin']) && !empty($dados['txtSenha']) && !empty($dados['txtSegundaSenha'])){

            if($dados['txtSenha'] == $dados['txtSegundaSenha']){

                $arrayDados = array(
                    "nome" => $dados['txtNome'],
                    "login" => $dados['txtLogin'],
                    "senha" => $dados['txtSenha']
                );

                if(insertUsuarios($arrayDados)){
                    return true;
                
                }else{
                    return array('idErro' => 1,
                                'message' => 'Não foi possível inserir os dados no Data Base.');
                }
            
            }else{
                return array('idErro' => 5,
                                'message' => 'As senhas precisam ser iguais.');
            }
        
        }else{
            return array('idErro' => 2,
                            'message' => 'Existem campos obrigatórios que não foram preenchidos.');
        }
    }
?>