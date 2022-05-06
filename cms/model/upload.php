<?php

/*Responsável por realizar o upload de arquivos. */

require_once('model/config.php');

    function uploadFile($arrayFile){
        
        $arquivo = $arrayFile;
        $sizeFile = (int) 0;
        $typeFile = (string) null;
        $nameFile = (string) null;
        $tempFile = (string) null; 

        /*Validação do arquivo para determinar se ele não está
         vazio e se possui uma extenção.*/
        if($arquivo['size'] > 0 && $arquivo['type'] != ""){

            $sizeFile = $arquivo['size'] /  1024;
            $typeFile = $arquivo['type'];
            $nameFile = $arquivo['name'];

            /*Recupera o caminho para o diretório temporário do 
            sevidor onde o arquivo se encontra. */
            $tempFile = $arquivo['tmp_name'];

            /*Validação do tamanho do arquivo de acordo com a 
            constante criada no arquivo config.php */
            if($sizeFile <= MAX_SIZE_FILE_UPLOAD){

                if(in_array($typeFile, EXTENSION_FILE_UPLOAD)){
                    
                    /*Separa o nome do arquivo de sua extenção.*/
                    $nome = pathinfo($nameFile, PATHINFO_FILENAME);
                    
                    /*Separa a extensão do arquivo de seu nome.*/
                    $extensao = pathinfo($nameFile, PATHINFO_EXTENSION);

                    /*Existem diversos algoritmos para a criptografia de dados no php:

                        md5()
                        sha1()
                        hash()
                    */

                    /*O  método uniqid() gera uma sequência numérica baseada no hadware
                    e nas configurações do Computador que fará o upload
                    O método time() retorna a hora atual medida no número de segundos desde a Era Unix (January 1 1970 00:00:00 GMT)..
                    
                    As duas sequências serão mescladas dentro do md5()*/
                    $nomeCriptografado = md5($nome . uniqid(time()));

                    /*Montando novamente o arquivo já com o nome criptografado. */
                    $foto = $nomeCriptografado . "." . $extensao;

                    /*Move o arquivo da pasta temporária do servidor para a pasta do projeto.*/
                    if(move_uploaded_file($tempFile, DIRECTORY_FILE_UPLOAD . $foto)){

                        return $foto;
                    
                    }else{
                        return array('idErro'   => 13,
                                     'message'  => 'Não foi possível mover o arquivo para o servidor.');    
                    } 

                }else{
                    return array('idErro'   => 12,
                                 'message'  => 'Extensão não suportada.');
                }
                
            }else{
                return array('idErro'   => 10,
                             'message'  => 'Tamanho do arquivo inváldo.');
            }
        
        }else{
            return array('idErro'   => 11,
                         'message'  => 'Nenhum arquivo foi selecionado.');
        }
    }


?>