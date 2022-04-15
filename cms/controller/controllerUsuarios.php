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

    function excluirUsuarios($id){

       if(!empty($id) && is_numeric($id)){

            if(deleteUsuarios($id)){
                return true;
            
            }else{
                return array('idErro'   => 3,
                             'message'  => 'O Data Base não pôde excluir o registro.');
            }
       
        }else{
            return array('idErro'   => 4,
                         'message'  => 'ID inválido.');
        }

    }

    function buscarUsuarios($id){

        if(!empty($id) && is_numeric($id)){

            $resposta = selectByIdUsuario($id);

            if(!empty($resposta)){
                return $resposta;
            }else{
                return false;
            }
        
        }else{
            return array('idErro'   => 4,
                         'message'  => 'ID inválido.');
        }
    }

    function atualizarUsuarios($dados, $id){

        if(!empty($dados['txtNome']) && !empty($dados['txtLogin']) && !empty($dados['txtSenha']) && !empty($dados['txtSegundaSenha'])){

            if($dados['txtSenha'] == $dados['txtSegundaSenha']){

                $arrayDados = array(
                    "id"    => $id,
                    "nome"  => $dados['txtNome'],
                    "login" => $dados['txtLogin'],
                    "senha" => $dados['txtSenha']
                );

                if(updateUsuarios($arrayDados)){
                    return true;
                
                }else{
                    return array('idErro' => 1,
                                'message' => 'Não foi possível atualizar os dados no Data Base.');
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