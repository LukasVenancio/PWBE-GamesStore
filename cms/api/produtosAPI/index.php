<?php

    /*Import do arquivo que fará as instâncias do SLIM. */
    require_once('vendor/autoload.php');

    /*Chamando um objeto Slim chamadp app, para configurar as EndPoints */
    $app = new \Slim\App();

    /*EndPoint: requisicão para listar todos os contatos */
    $app->get('/produtos', function($request, $response, $args){

    });

    /*EndPoint: requisicão para listar um contato pelo ID */
    $app->get('/produtos/{}', function($request, $response, $args){

    });

    /*EndPoint: requisicão para inserir um contato*/
    $app->post('/produtos', function($request, $response, $args){

    });

?>