<?php

    require_once('conexaoMysql.php');

    function selectAllUsuarios (){

        $conexao = conectarMysql();
        $sql = "select * from tblusuarios;";
        
        $result = mysqli_query($conexao, $sql);

        if(!empty($result)){

            $contador = 0;

            while($resultArray = mysqli_fetch_assoc($result)){

                $dados[$contador] = array(
                    "id"    => $resultArray['idusuario'],
                    "nome"  => $resultArray['nome'],
                    "login" => $resultArray['login'],
                    "senha" => $resultArray['senha']
                );
                
                $contador++;
            }

            fecharConexaoMysql($conexao);

            return $dados;
        }
    }

    function insertUsuarios($dados){

        $response = (boolean) false;

        $conexao = conectarMysql();
        $sql = "insert into tblusuarios(nome, login, senha)
                values(
                        '".$dados['nome']."',
                        '".$dados['login']."', 
                        '".$dados['senha']."' );";

        if(mysqli_query($conexao, $sql)){

            if(mysqli_affected_rows($conexao)){
                $response = true;
            }
        }

        fecharConexaoMysql($conexao);
        return $response;
    }
    



?>