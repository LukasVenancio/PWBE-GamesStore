<?php
    require_once('./cms.php')
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
            <form action="router.php?component=usuarios&action=inserir">
                <div class="label">
                    <label>Nome:</label>
                </div>
                <input type="text" name="txtNome">
                <div class="label">
                    <label>Login:</label>
                </div>
                <input type="text" name="txtLogin">
                <div class="label">
                    <label>Senha:</label>
                </div>
                <input type="password" name="txtSenha">
                <div class="label">
                    <label>Confirmar senha:</label>
                </div>
                <input type="password" name="txtSegundaSenha">
                <input type="submit" value="Salvar" class="form-button">
            </form>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <td>Nome</td>
                    <td>Login</td>
                    <td>Senha</td>
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
                    <td><?=$usuario['senha']?></td>
                    <td>
                        <a href="">
                            <img src="img/lata-de-lixo.png" alt="">
                        </a>
                        <a href="">
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