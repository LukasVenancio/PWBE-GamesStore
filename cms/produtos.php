<?php
    require_once('./cms.php');
    require_once('./model/config.php');
    require_once('./controller/controllerCategorias.php');

    $destaque = null;
    $imagem = (string) null;
    $idCategoria = (string) null;

    $form = "router.php?component=produtos&action=inserir";

    if(session_status()){

        if(!empty($_SESSION['dadosProdutos'])){

            $id =           $_SESSION['dadosProdutos']['id'];
            $descricao =    $_SESSION['dadosProdutos']['descricao'];
            $imagem =       $_SESSION['dadosProdutos']['imagem'];
            $preco =        $_SESSION['dadosProdutos']['preco'];
            $desconto =     $_SESSION['dadosProdutos']['desconto'];
            $destaque=      $_SESSION['dadosProdutos']['destaque'];
            $idCategoria=   $_SESSION['dadosProdutos']['idcategoria'];

            $form = "router.php?component=produtos&action=editar&id=".$id."&imagem=".$imagem;

            unset($_SESSION['dadosProdutos']);
        }
    }
?>    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/produtos.css">
    <script src="js/imagePreview.js" defer></script>
    <title>Adm. Produtos</title>
</head>
<body>
    <div class="area-container">
        <div class="form-container">
            <form action="<?=$form?>" name="frmProdutos" enctype="multipart/form-data" method="post">
                
                <div class="container-descricao linha">
                    <label>Descrição:</label>
                    <input type="text" name="txtDescricao" value="<?=isset($descricao)?$descricao:null?>">
                </div>

                <div class="container-foto linha">
                    <label for="image-input" id="image-label">Selecione uma imagem:</label>
                    <img src="<?=DIRECTORY_FILE_UPLOAD.$imagem?>" alt="" class="imagem-form" id="image-container">
                    <!-- enctype = multipart/form-data  é obrigatório para 
                    fazer upload de formatos de arquivos para o back-end -->
                    <input type="file" name="fleFoto" accept=".jpg, .png, .jpeg, .gif" id="image-input">
                </div>

                <div class="container-preco linha">
                    <label>Preço:</label>
                    <input type="text" name="txtPreco" value="<?=isset($preco)?$preco:null?>">
                </div>

                <div class="container-desconto linha">
                    <label>Desconto:</label>
                    <input type="text" name="txtDesconto" value="<?=isset($desconto)?$desconto:null?>">
                </div>
                <div class="container-categoria linha">
                    <label>Categoria:</label>
                    <select name="sltCategoria" id="">
                        <option value="">Selecione um item</option>
                        <?php
                        
                            require_once('controller/controllerCategorias.php');
                            $listaCategorias = listarCategoria();

                            foreach($listaCategorias as $option){

                                ?>

                                    <option value="<?=$option['id']?>" <?=$idCategoria == $option['id'] ? 'selected' : null ?>><?=$option['nome']?></option>

                                <?php

                            }
                        
                        ?>
                    </select>
                </div>
                <div class="container-destaque linha">
                    <label>Produto em destaque?</label>
                    <input type="checkbox" name="chbxDestaque" class="inputDestaque" <?=$destaque == '1'?'checked':null?>>
                </div>
                <input type="submit" value="Salvar" class="salvar">
            </form>
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <td>Descrição</td>
                    <td>Imagem</td>
                    <td>Preço</td>
                    <td>Desconto</td>
                    <td>Destaque</td>
                    <td>Categoria</td>
                    <td>Opções</td>
                </tr>
                <?php

                    require_once('controller/controllerProdutos.php');

                    $dados = listarProdutos();

                    if($dados){

                        foreach($dados as $produto){

                            $imagem = $produto['imagem'];
                            $categoria = buscarCategoria($produto['idcategoria']);

                ?>
                <tr>
                    <td><?=$produto['descricao']?></td>
                    <td class="td-imagem">
                        <img src="<?=DIRECTORY_FILE_UPLOAD.$imagem?>" alt="">
                    </td>
                    <td><?=$produto['preco']?></td>
                    <td><?=$produto['desconto']?></td>
                    <td><?=$produto['destaque'] == '1' ? 'Sim':'Não'?></td>
                    <td><?=$categoria['nome']?></td>
                    <td class="td-opcoes">
                        <a onclick="return confirm('Deseja excluir o registro?')" href="router.php?component=produtos&action=deletar&id=<?=$produto['id']?>&image=<?=$imagem?>">
                            <img src="img/lata-de-lixo.png" alt="" title="Excluir">
                        </a>
                        <a href="router.php?component=produtos&action=buscar&id=<?=$produto['id']?>">
                            <img src="img/editar.png" alt="" title="Editar">
                        </a>
                    </td>
                </tr>

                <?php
                    }
                 }    
                ?>
            </table>
        </div>
    </div>
</body>
</html>