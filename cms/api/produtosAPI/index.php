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

        $id = $args['id'];

        $dados = buscarProdutos($id);

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
    
    /*EndPoint: requisicão para inserir um contato*/
    $app->post('/produtos', function($request, $response, $args){

    });

    $app->run();

?>