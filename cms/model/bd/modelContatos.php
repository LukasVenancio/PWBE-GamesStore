<?php
/*Arquivo responsável por manipular diretamente os dados do Data Base. */

require_once('./model/bd/conexaoMysql.php');

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

function deleteContato($id){

    $conexao = conectarMysql();
    $sql = "delete from tblcontatos where idcontato = " . $id . ";";

    $resposta = (boolean) false;

    /*Executando o script no Data Base (passando como parâmetros o próprio db e
    o script que será executado) e verificando se o script está correto através do if. */
    if(mysqli_query($conexao, $sql)){

        /*Verificação de uma atualização no db(se uma linha foi deletada),
         ou seja, se o db aceitou o script. */
         if(mysqli_affected_rows($conexao)){
             $resposta = true;
         }
    }

    fecharConexaoMysql($conexao);

    return $resposta;


}



?>