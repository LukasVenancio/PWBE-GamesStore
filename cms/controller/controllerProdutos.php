<?php

    require_once('model/bd/modelProdutos.php');
    require_once('model/config.php');

    function inserirProdutos($dados, $file){

        $resultadoUpload = (string) null;

        if(!empty($dados)){

            if(!empty($dados['txtDescricao']) && !empty($dados['txtPreco'])){
                
                /*Idenfica se o usuário tentou fazer um upload de uma imagem. */ 
                if($file['fleFoto']['name'] != null){
            
                    require_once('model/upload.php');

                    /*Chamando a função da model que resgata a imagem.  */
                    $resultadoUpload = uploadFile($file['fleFoto']);

                    if(!is_array($resultadoUpload)){

                        $arrayDados = array(

                            "descricao" => $dados['txtDescricao'],
                            "imagem" => $resultadoUpload,
                            "preco" => $dados['txtPreco'],
                            "desconto" => $dados['txtDesconto']
                        );

                        if(insertProdutos($arrayDados)){
                            return true;
                        
                        }else{
                            return array('idErro' => 1,
                                        'message' => 'Não foi possível inserir os dados no Data Base.');
                        }

                    }else{
                        /*Caso aconteça algum erro no processo de upload,
                        a função retorna um array com a mensagem de erro, esse
                        array será retornado para a router que o exibirá.  */
                        return $resultadoUpload;
                    }
                
                }else{
                    return array('idErro' => 17,
                                'message' => 'Uma imagem não foi selecionada.');
                }
            
            }else{
                return array('idErro' => 2,
                            'message' => 'Existem campos obrigatórios que não foram preenchidos.');
            }
        }
    }

    function listarProdutos(){
        
        $resultado = selectAllProdutos();

        if(!empty($resultado)){
            return $resultado;

        }else{
            return false;
        }
    }

    function excluirProdutos($produto){

        if(!empty($produto['id']) && is_numeric($produto['id'])){

           if(deleteProduto($produto['id'])){

                if(unlink(DIRECTORY_FILE_UPLOAD.$produto['image'])){
                    return true;
                
                }else{
                    return array('idErro'   => 18,
                                 'message'  => 'A imagem do registro não foi excluída da pasta de arquivos.');
                }
            
            }else{
                return array('idErro'   => 3,
                             'message'  => 'O Data Base não pôde excluir o registro.');
            }
        
        }else{
            return array('idErro'   => 4,
                         'message'  => 'ID inválido.');
        }
    }

    function buscarProdutos($id){

        if(!empty($id) && is_numeric($id)){

            $resposta = selectByIdProdutos($id);

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
?>