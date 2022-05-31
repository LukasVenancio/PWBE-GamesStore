<?php

    require_once(SRC . 'model/bd/modelProdutos.php');
    require_once(SRC . 'model/config.php');

    function inserirProdutos($dados){

        $resultadoUpload = (string) null;
        $destaque = (int) 0;

        if(!empty($dados)){

            $file = $dados['file'];

            if(!empty($dados[0]['descricao']) && !empty($dados[0]['preco']) && !empty($dados[0]['categoria'])){
                
                /*Idenfica se o usuário tentou fazer um upload de uma imagem. */ 
                if($file['foto']['name'] != null){
            
                    require_once(SRC . 'model/upload.php');

                    /*Chamando a função da model que resgata a imagem.  */
                    $resultadoUpload = uploadFile($file['foto']);


                    if(!is_array($resultadoUpload)){

                        if($dados[0]['destaque']){
                            
                            if($dados[0]['destaque'] == 'on'){
                                $destaque = 1;
                            }
                        }

                        $arrayDados = array(

                            "descricao"     => $dados[0]['descricao'],
                            "imagem"        => $resultadoUpload,
                            "preco"         => $dados[0]['preco'],
                            "desconto"      => $dados[0]['desconto'],
                            "destaque"      => $destaque,
                            "idcategoria"   => $dados[0]['categoria']
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

                if(@unlink(SRC . DIRECTORY_FILE_UPLOAD.$produto['image'])){
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

    function atualizarProdutos($dados){

        //var_dump($dados['file']);
        //die;

        $statusUpload = (boolean) false;
        $resultadoUpload = (string) null;

        $defaultImage = (string) null;

        $destaque = (int) 0;

        $id = $dados['id'];
        $imagem = $dados['imagemAntiga'];
        $file = $dados['file'];

        if(!empty($dados)){

            if(!empty($dados[0]['descricao']) && !empty($dados[0]['preco'])){
                
                /*Idenfica se o usuário tentou fazer um upload de uma imagem. */ 
                if($file['foto']['name'] != null){
            
                    require_once(SRC . 'model/upload.php');
                    $statusUpload = true;

                    /*Chamando a função da model que resgata a imagem.  */
                    $resultadoUpload = uploadFile($file['foto']);

                    if(!is_array($resultadoUpload)){

                        $defaultImage = $resultadoUpload;
                    
                    }else{
                    
                        /*Caso aconteça algum erro no processo de upload,
                         a função retorna um array com a mensagem de erro, esse
                         array será retornado para a router que o exibirá.  */
                         return $resultadoUpload;
                    }
                
                }elseif($imagem != null){
                    $defaultImage = $imagem;
                }

                if(isset($dados[0]['destaque'])){

                    if($dados[0]['destaque'] == 'on'){
                        $destaque = 1;
                    }
                }


                $arrayDados = array(
                            "id"            => $id,
                            "descricao"     => $dados[0]['descricao'],
                            "imagem"        => $defaultImage,
                            "preco"         => $dados[0]['preco'],
                            "desconto"      => $dados[0]['desconto'],
                            "destaque"      => $destaque,
                            "idcategoria"   => $dados[0]['idcategoria']
                            );

                //var_dump($arrayDados);
                //die;

                if(updateProdutos($arrayDados)){

                    if($statusUpload){
                        unlink(SRC. DIRECTORY_FILE_UPLOAD . $imagem);
                    }

                    return true;
                }else{
                    return array('idErro' => 1,
                                'message' => 'Não foi possível atualizar os dados no Data Base.');
                }
                
            }else{
                return array('idErro' => 2,
                            'message' => 'Existem campos obrigatórios que não foram preenchidos.');
            }
        }        

    }
?>