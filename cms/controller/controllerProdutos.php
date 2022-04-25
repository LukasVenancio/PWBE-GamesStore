<?php

    function inserirProdutos($dados, $file){

        if($file != null){
            
            require_once('model/upload.php');

            $resultado = uploadFile($file['fleFoto']);

            echo($resultado);
            die;
        }
    }



?>