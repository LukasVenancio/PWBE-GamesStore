<?php
    require_once('./cms.php');

    $form = "router.php?component=usuarios&action=inserir";

    if(session_status()){

        if(!empty($_SESSION['dadosUsuarios'])){

            $id = $_SESSION['dadosUsuarios']['id'];
            $nome = $_SESSION['dadosUsuarios']['nome'];
            $login = $_SESSION['dadosUsuarios']['login'];
            $senha = $_SESSION['dadosUsuarios']['senha'];
    
            $form = "router.php?component=usuarios&action=editar&id=" . $id;
    
            unset($_SESSION['dadosUsuarios']);
        }

    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarios.css">
    <title>Adm. Usuários</title>
</head>
<body>
    <div class="area-container">
        <div class="form-container">
            <form action="<?=$form?>" method="post" name="formUsuarios">
                <div class="label">
                    <label>Nome:</label>
                </div>
                <input type="text" name="txtNome" value="<?=isset($nome)?$nome:null?>">
                <div class="label">
                    <label>Login:</label>
                </div>
                <input type="text" name="txtLogin" value="<?=isset($login)?$login:null?>">
                <div class="label">
                    <label>Senha:</label>
                </div>
                <input type="password" name="txtSenha" value="<?=isset($senha)?$senha:null?>">
                <div class="label">
                    <label>Confirmar senha:</label>
                </div>
                <input type="password" name="txtSegundaSenha" value="<?=isset($senha)?$senha:null?>">
                <input type="submit" value="Salvar" class="form-button">
            </form>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <td>Nome</td>
                    <td>Login</td>
                    <td>Opções</td>
                </tr>

            <?php

                require_once('controller/controllerUsuarios.php');

                $usuarios = listarUsuarios();

                foreach($usuarios as $usuario){
            ?>
                <tr>
                    <td><?=$usuario['nome']?></td>
                    <td><?=$usuario['login']?></td>
                    <td>
                        <a onclick="return confirm('Deseja excluir o registro?')" href="router.php?component=usuarios&action=deletar&id=<?=$usuario['id']?>">
                            <img src="img/lata-de-lixo.png" alt="">
                        </a>
                        <a href="router.php?component=usuarios&action=buscar&id=<?=$usuario['id']?>">
                            <img src="img/editar.png" alt="">
                        </a>
                    </td>
                </tr>

            <?php
                }
            ?>

            </table>
        </div>
    </div>
</body>
</html>