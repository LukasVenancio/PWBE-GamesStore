<?php
    require_once(SRC . 'model/bd/conexaoMysql.php');

    function selectAllProdutos(){

        $conexao = conectarMysql();
        $sql = "select * from tblprodutos;";

        $result = mysqli_query($conexao, $sql);

        if($result){

            $contador = 0;

            while($resultArray = mysqli_fetch_assoc($result)){

                $dados[$contador] = array(
                    "id"            => $resultArray['idproduto'],
                    "descricao"     => $resultArray['descricao'],
                    "imagem"        => $resultArray['imagem'],
                    "preco"         => $resultArray['preco'],
                    "desconto"      => $resultArray['desconto'],
                    "destaque"      => $resultArray['destaque'],
                    "idcategoria"   => $resultArray['idcategoria']
                );

                $contador++;
            }

            fecharConexaoMysql($conexao);

            if(isset($dados)){
                return $dados;
            
            }else{
                return false;
            }
            
        }
    }

    function insertProdutos($dados){
        
        $resposta = (boolean) false;

        $conexao = conectarMysql();
        $sql = "insert into tblprodutos(descricao, imagem, preco, desconto, destaque, idcategoria)
                    values('". $dados['descricao']."',
                            '". $dados['imagem'] ."', 
                            ". $dados['preco'] .",
                            ". $dados['desconto'] .",
                            ". $dados['destaque'].",
                            ". $dados['idcategoria'].");";

        if(mysqli_query($conexao, $sql)){

            if(mysqli_affected_rows($conexao)){
                $resposta = true;
            }
        }

        fecharConexaoMysql($conexao);

        return $resposta;
    }

    function deleteProduto($id){

        $conexao = conectarMysql();
        $sql = "delete from tblprodutos where idproduto = ". $id .";";

        $resposta = (boolean) false;

        if(mysqli_query($conexao, $sql)){

            if(mysqli_affected_rows($conexao)){

                $resposta = true;
            }
        }

        fecharConexaoMysql($conexao);

        return $resposta;
    }

    function selectByIdProdutos($id){

        $conexao = conectarMysql();
        $sql = "select * from tblprodutos where idproduto = " . $id . ";";

        $result = mysqli_query($conexao, $sql);

        if($result){

            if($resultArray = mysqli_fetch_assoc($result)){
                $dados = array(
                    "id"            => $resultArray['idproduto'],
                    "descricao"     => $resultArray['descricao'],
                    "imagem"        => $resultArray['imagem'],
                    "preco"         => $resultArray['preco'],
                    "desconto"      => $resultArray['desconto'],
                    "destaque"      => $resultArray['destaque'],
                    "idcategoria"   => $resultArray['idcategoria']
                );
            }
        }

        fecharConexaoMysql($conexao);

        if(isset($dados)){
            return $dados;
        
        }else{
            return false;
        }
        
    }

    function updateProdutos($dados){

        $response = (boolean) false;
        
        $conexao = conectarMysql();
        $sql = "update tblprodutos set 
                    descricao ='".$dados['descricao']."', 
                    imagem='".$dados['imagem']."',
                    preco=".$dados['preco'].",
                    desconto=".$dados['desconto'].",
                    destaque=".$dados['destaque'].", 
                    idcategoria=".$dados['idcategoria']." 
                where idproduto =".$dados['id'].";";

        if(mysqli_query($conexao, $sql)){

            if(mysqli_affected_rows($conexao)){
                $response = true;
            }
        }
        
        fecharConexaoMysql($conexao);
        return $response;
    }

?>