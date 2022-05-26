<?php

    /*Import do arquivo que fará as instâncias do SLIM. */
    require_once('vendor/autoload.php');

    require_once('../model/config.php');
    require_once('../controller/controllerProdutos.php');

    /*Chamando um objeto Slim chamadp app, para configurar as EndPoints */
    $app = new \Slim\App();

    /* $request:    Recebe dados do corpa da requisição.
        $response:  Envia dados de retorno da API.
        $args:      Permite receber dados de atributos na API*/

    /*EndPoint: requisicão para listar todos os Produtos*/
    $app->get('/produtos', function($request, $response, $args){

        $dados = listarProdutos();

        if($dados){

            $dadosJson = toJSON($dados);

            if($dadosJson){

               return $response     ->withHeader('Content-Type', 'application/json')
                                    ->write($dadosJson)
                                    ->withStatus(200);
            }
        
        }else{
           return $response     ->withStatus(404)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('[{"message" : "Item não encontrado"}]');
        }

    });

    /*EndPoint: requisicão para listar um Produto pelo ID */
    $app->get('/produtos/{id}', function($request, $response, $args){

        /*Recebe a variável criada no EndPoint.*/
        $id = $args['id'];

        $dados = buscarProdutos($id);

        if($dados){

            if(!isset($dados['idErro'])){

                $dadosJson = toJSON($dados);

                if($dadosJson){

                return $response    ->withHeader('Content-Type', 'application/json')
                                    ->write($dadosJson)
                                    ->withStatus(200);
                }
            
            }else{
                return $response    ->withStatus(404)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('[{"message" : "ID inválido."}]');    
            }
        
        }else{
            return $response    ->withStatus(204);
        }
        
    });
    
    /*EndPoint: requisicão para inserir um Produto*/
    $app->post('/produtos', function($request, $response, $args){

        /*Recuperando o formato de dados do header da requisição.*/
        $contentTypeHeader = $request->getHeaderLine('Content-Type');

        /*Separa a variável em um array, contendo somente o formData.*/
        $contentType = explode(";", $contentTypeHeader);

        if($contentType[0] == 'multipart/form-data'){

            /*Recupera os dados do body da requisiçõo.*/
            $bodyData = $request->getParsedBody();

            /*Recupera a imagem passada pelo body da requisiçõo.*/
            $uploadFiles = $request->getUploadedFiles();
        
            /*Cria um array com os dados protegidos (que são recuperados 
            através dos métodos) da imagem da requisição.*/
            $arrayFoto = array("name"       =>  $uploadFiles['foto']->getClientFileName(),
                                "type"      =>  $uploadFiles['foto']->getClientMediaType(),
                                "size"      =>  $uploadFiles['foto']->getSize(),
                                "tmp_name"  =>  $uploadFiles['foto']->file);

            
            /*Simula um objeto HTML que enviaria a imagem com chave 'foto',
             de acordo com o que foi feito no arquivo Router. */                    
            $file = array('foto' => $arrayFoto);

            $dados = array(
                $bodyData,
                'file' => $file
            );

            $resposta = inserirProdutos($dados);

            if(is_bool($resposta) && $resposta){

                return $response    ->withStatus(201)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('[{"message" : "Registro inserido com sucesso!"}]');
            
            }elseif(is_array($resposta) && isset($resposta['idErro'])){

                return $response    ->withStatus(400)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('[{"message":   "Não foi possível inserir o registro.",
                                                "Erro:":    "'.$resposta['message'].'"}]');

            }
        
        }elseif($contentType[0] == 'application/json'){

        
        }else{
            return $response    ->withStatus(400)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('[{"message" : "Formato de dados inválido."}]'); 
        }

    });

    $app->delete('/produtos/{id}', function($request, $response, $args){

        if(is_numeric($args['id'])){

            $id = $args['id'];

            /*Busca o produto pelo nome para descobrir qual é o nome da 
            imagem que deve ser apaga da pasta de aquivos. */
            $dados = buscarProdutos($id);

            if($dados){

                $image = $dados['imagem'];

                /*Montamos um array para que sejam enviados para a model o id do produto e sua imagem.*/
                $arrayDados = array(
                    "id"    => $id,
                    "image" =>$image
                );

                $respostaController = excluirProdutos($arrayDados);

                if(is_bool($respostaController) && $respostaController){

                    return $response    ->withHeader('Content-Type', 'application/json')
                                        ->write('[{"message": "Registro excluído com sucesso."}]')
                                        ->withStatus(200);                    

                }elseif(is_array($respostaController)){

                    $respostaControllerJSON = toJSON($respostaController);

                    /*Verificando se houve o erro de não poder apagar a imagem da pasta de arquivos.*/
                    if($respostaController['idErro'] == 18){

                        /*Retornando um status 200 (pois o produto foi apagado com sucesso) e 
                        informando que não foi possível apagar a imagem. */
                        return $response    ->withStatus(200)
                                            ->withHeader('Content-Type', 'application/json')
                                            ->write('[{"message":   "Registro excluído com sucesso.",
                                                        "Erro:":    "'.$respostaControllerJSON.'"}]');
                    }

                    return $response    ->withStatus(404)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write('[{"message":   "Ocorreu um erro.",
                                                    "Erro:":    "'.$respostaControllerJSON.'"}]');
                }

            }else{

                return $response    ->withStatus(404)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('[{"message" : "ID não encontrado."}]');
            }

        }else{

            return $response    ->withStatus(404)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('[{"message" : "ID inválido."}]');
        }

    });

    $app->run();

?>