<?php
    require_once('./cms.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/contatos.css">
    <title>CMS-Contatos</title>
</head>
<body>
    <div class="area-container">
        <table>
            <tr>
                <td>Nome</td>
                <td>Email</td>
                <td>Ação</td>
            </tr>

            <?php
            
                require_once('controller/controllerContatos.php');

                $listaDeContatos = listarContatos();

                foreach($listaDeContatos as $contato){

            ?>
            <tr>
                <td><?=$contato['nome']?></td>
                <td><?=$contato['email']?></td>
                <td>
                    <a href="router.php?component=contatos&action=deletar&id=<?=$contato['id']?>">
                        <img src="img/lata-de-lixo.png" alt="">
                    </a>
                    <img src="img/magnify.png" alt="">
                </td>
            </tr>

            <?php
            
                };
            
            ?>
        </table>        
    </div>
</body>
</html>