<?php
    require_once('./cms.php');


    /**create table tblcategorias(
				idcategoria int not null auto_increment primary key,
                nome varchar(50) not null);
show tables;

insert into tblcategorias(nome)
					value('Terror'); */
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
            <form action="router.php?component=categorias&action=inserir" method="post">
                <div class="form-superior">
                    <label>Nome:</label>
                    <input type="text" name="txtNome">
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
                    <td>Ação</td>
                </tr>
                <?php
                        require_once('controller/controllerCategorias.php');

                        $categorias = listarCategorias();

                        foreach($categorias as $categoria){

                    ?>
                <tr>
                    <td><?=$categoria['nome']?></td>
                    <td>
                        <img src="img/lata-de-lixo.png" alt="" title="Excluir">
                        <img src="img/editar.png" alt="" title="Editar">
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