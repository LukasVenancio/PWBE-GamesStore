<?php
    require_once('./cms.php');

    $id = (String) null;
    $nome = (String) null;

    if(session_status()){

        if(!empty($_SESSION['dadosCategorias'])){

            $id = $_SESSION['dadosCategorias']['id'];
            $nome = $_SESSION['dadosCategorias']['nome'];
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/categorias.css">
    <title>Adm. Categorias</title>
</head>
<body>
    <div class="area-container">
        <div class="form-container">
            <form action="router.php?component=categorias&action=inserir" method="post" name="formCategoria">
                <div class="form-superior">
                    <label>Nome:</label>
                    <input type="text" name="txtNome" value="<?=$nome?>">
                </div>
                <div class="form-inferior">
                    <input type="submit" value="Salvar">
                </div>
            </form>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <td>Nome</td>
                    <td>Opções</td>
                </tr>
                <?php
                        require_once('controller/controllerCategorias.php');

                        $categorias = listarCategorias();

                        foreach($categorias as $categoria){

                    ?>
                <tr>
                    <td><?=$categoria['nome']?></td>
                    <td>
                        <a onclick="return confirm('Deseja excluir o registro?')" href="router.php?component=categorias&action=deletar&id=<?=$categoria['id']?>">
                            <img src="img/lata-de-lixo.png" alt="" title="Excluir">
                        </a>
                        <a href="router.php?component=categorias&action=buscar&id=<?=$categoria['id']?>">
                            <img src="img/editar.png" alt="" title="Editar">
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