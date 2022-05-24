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

    /*EndPoint: requisicão para listar todos os contatos */
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

    /*EndPoint: requisicão para listar um contato pelo ID */
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
    
    /*EndPoint: requisicão para inserir um contato*/
    $app->post('/produtos', function($request, $response, $args){

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
                                        ->write('"message": "Registro excluído com sucesso."')
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