<?php

    /*Resposável pela criação de variáveis
    e constantes do projeto. */

    const MAX_SIZE_FILE_UPLOAD = 10240;
    const EXTENSION_FILE_UPLOAD = array("image/jpg", "image/png", "image/gif", "image/jpeg");
    const DIRECTORY_FILE_UPLOAD = "arquivos/";
    
    define('SRC', $_SERVER['DOCUMENT_ROOT'] . '/lukas/PWBEGamesStore/cms/');

    /*Funções globais para o projeto*/

    /*Função para converter um array em um JSON */
    function toJSON($arrayDados){

        if($arrayDados != null){

            /*Configura o padrão da conversão para o formato JSON. */
            header('Content-Type: application/json');

            /*Converte um array para JSON.*/
            $jsonDados = json_encode($arrayDados);

            /*json_decode(): converte um JSON para array */

            return $jsonDados;
        
        }else{
            return false;
        }

    }

?>