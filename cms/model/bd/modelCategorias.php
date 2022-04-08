<?php
/*Arquivo responsável por manipular diretamente os dados e o Data Base em si.*/

require_once('model/bd/conexaoMysql.php');

    function selectAllCategorias(){
        
        $conexao = conectarMysql();
        $sql = "select * from tblcategorias;";

        /*A variável $result recebe os dados sobre as categorias que retornaram do DB.*/
        $result = mysqli_query($conexao, $sql);

        /*Verificando se houve resultado. */
        if($result){
            
            $contator = 0;

            /*O método mysqli_fetch_assoc() converte os dados que retornam do
            DB em um array e mantém o while enquanto ainda 
            houverem dados a serem convertidos. */
            while($resultArray = mysqli_fetch_assoc($result)){

                $dados[$contator] = array(
                    "id"    => $resultArray['idcategoria'],
                    "nome"  => $resultArray['nome']
                );
                
                $contator++;
            }

            fecharConexaoMysql($conexao);

            return $dados;
        
        }
    }

    function insertCategoria($dadosCategoria){
        $resposta = (boolean) false;
        
        $conexao = conectarMysql();
        $sql = "insert into tblcategorias(nome)
                            value('".$dadosCategoria['nome']."');";

        /*Executando o script e verificando se o resultado foi positivo.*/
        if(mysqli_query($conexao, $sql)){

            /*Verificando se houve alguma linha afetada (adicionada) no DB
            (serve como uma segunda linha de validação do script). */
            if(mysqli_affected_rows($conexao)){
                $resposta = true;
            }
        }                            
        
        fecharConexaoMysql($conexao);

        return $resposta;
    
    }

    function deleteCategoria($id){

        $conexao = conectarMysql();
        $sql = "delete from tblcategorias where idcategoria = ". $id . ";";

        $resposta = (boolean) false;

        /*Executando o script no DB e verificando se o 
        retorno foi positivo através if().*/
        if(mysqli_query($conexao, $sql)){
            
            /*Verificando se alguma linha foi afetada no Data Base. */
            if(mysqli_affected_rows($conexao)){
                $resposta = true;
            }
        }

        fecharConexaoMysql($conexao);

        return $resposta;
    }

    function selectByIdCategoria($id){

        $conexao = conectarMysql();
        $sql = "select * from tblcategorias where idcategoria = " . $id . ";";

        $result = mysqli_query($conexao, $sql);

        if($result){

            if($resultArray = mysqli_fetch_assoc($result)){

                $dados = array(
                    "id" => $resultArray['idcategoria'],
                    "nome" => $resultArray['nome']
                );
            }
        }

        fecharConexaoMysql($conexao);

        return $dados;

    }




?>