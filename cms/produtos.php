<?php
    require_once('./cms.php');
?>    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm. Produtos</title>
</head>
<body>
    <!-- enctype = multipart/form-data  é obrigatório para 
    fazer upload de formatos de arquivos para o back-end -->
    <form action="router.php?component=produtos&action=inserir" name="frmProdutos" enctype="multipart/form-data" method="post">
        <input type="file" name="fleFoto" accept=".jpg, .png, .jpeg, .gif">
        <input type="submit" value="salvar">
    </form>
</body>
</html>