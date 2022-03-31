<?php
/*Arquivo responsável por manipular diretamente os dados do Data Base. */

require_once('conexaoMysql.php');

function selectAllContatos(){
    
    $conexao = conectarMysql();
    $sql = "select * from tblcontatos order by idcontato desc;";

    /*Quando executamos o comando mysqli_query() com um script de select, 
    seu retorno passa a ser de informações que retornam do Data Base. */
    $result = mysqli_query($conexao, $sql);

    /*Verificando se houve um retorno do db. */
    if($result){

        $contador = 0;

        /*O método mysqli_fetch_assoc() converte os dados que rertonaram do db em um array, 
        e mantém a repetição do while enquanto ainda houverem dados à serem convertidos. */
        while($resultArray = mysqli_fetch_assoc($result)){

            /*Recupera apenas os dados necessários e descarta as outras informações sobre a conexão. */
            $dados[$contador] = array(
                "id" => $resultArray['idcontato'],
                "nome" => $resultArray['nome'],
                "email" => $resultArray['email'],
                "mensagem" => $resultArray['mensagem']
            );

            $contador++;
        }

        fecharConexaoMysql($conexao);

        return $dados;
    }
}



?>