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
                        md5('".$dados['senha']."') );";

        // var_dump($sql);
        // die;                

        if(mysqli_query($conexao, $sql)){

            if(mysqli_affected_rows($conexao)){
                $response = true;
            }
        }

        fecharConexaoMysql($conexao);
        return $response;
    }

    function deleteUsuarios($id){

        $response = (boolean) false;

        $conexao = conectarMysql();
        $sql = "delete from tblusuarios where idusuario =". $id .";";

        if(mysqli_query($conexao, $sql)){

            if(mysqli_affected_rows($conexao)){
                $response = true;
            }
        }

        fecharConexaoMysql($conexao);
        return $response;
    }

    function selectByIdUsuario($id){

        $conexao = conectarMysql();
        $sql = "select * from tblusuarios where idusuario =" .$id.";";

        $dados = mysqli_query($conexao, $sql);

        if($dados){

            if($dadosArray = mysqli_fetch_assoc($dados)){

                $result = array(
                    "id"    => $dadosArray['idusuario'],
                    "nome"  => $dadosArray['nome'],
                    "login" => $dadosArray['login'],
                    "senha" => $dadosArray['senha']
                );
            }
        }

        fecharConexaoMysql($conexao);

        return $result;
    }

    function updateUsuarios($dados){
        
        $response = (boolean) false;

        $conexao = conectarMysql();
        $sql = "update tblusuarios set 
                            nome ='".$dados['nome']."', 
                            login='".$dados['login']."',
                            senha= md5('".$dados['senha']."')  
                where idusuario =".$dados['id'].";";

        if(mysqli_query($conexao, $sql)){

            if(mysqli_affected_rows($conexao)){
                $response = true;
            }
        }

        fecharConexaoMysql($conexao);
        return $response;


    }
    



?>