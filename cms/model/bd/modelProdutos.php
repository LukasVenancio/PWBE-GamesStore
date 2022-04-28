<?php
    require_once('model/bd/conexaoMysql.php');

    function selectAllProdutos(){

        $conexao = conectarMysql();
        $sql = "select * from tblprodutos;";

        $result = mysqli_query($conexao, $sql);

        if($result){

            $contador = 0;

            while($resultArray = mysqli_fetch_assoc($result)){

                $dados[$contador] = array(
                    "id"        => $resultArray['idproduto'],
                    "descricao" => $resultArray['descricao'],
                    "imagem"    => $resultArray['imagem'],
                    "preco"     => $resultArray['preco'],
                    "desconto"  => $resultArray['desconto']
                );

                $contador++;
            }

            fecharConexaoMysql($conexao);

            return $dados;
        }
    }

    function insertProdutos($dados){
        
        $resposta = (boolean) false;

        $conexao = conectarMysql();
        $sql = "insert into tblprodutos(descricao, imagem, preco, desconto)
                    values('". $dados['descricao']."',
                            '". $dados['imagem'] ."', 
                            ". $dados['preco'] .",
                            ". $dados['desconto'] .");";

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

?>