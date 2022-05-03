<?php
    require_once('./cms.php');
    require_once('./model/config.php');

    $imagem = (string) null;

    $form = "router.php?component=produtos&action=inserir";

    if(session_status()){

        if(!empty($_SESSION['dadosProdutos'])){

            $id =           $_SESSION['dadosProdutos']['id'];
            $descricao =    $_SESSION['dadosProdutos']['descricao'];
            $imagem =       $_SESSION['dadosProdutos']['imagem'];
            $preco =        $_SESSION['dadosProdutos']['preco'];
            $desconto =     $_SESSION['dadosProdutos']['desconto'];

            $form = "router.php?component=produtos&action=editar&id=" . $id . "&imagem= " . $imagem;

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
                    <label>Selecione uma imagem:</label>
                    <img src="<?=DIRECTORY_FILE_UPLOAD.$imagem?>" alt="" class="imagem-form">
                    <!-- enctype = multipart/form-data  é obrigatório para 
                    fazer upload de formatos de arquivos para o back-end -->
                    <input type="file" name="fleFoto" accept=".jpg, .png, .jpeg, .gif">
                </div>

                <div class="container-preco linha">
                    <label>Preço:</label>
                    <input type="text" name="txtPreco" value="<?=isset($preco)?$preco:null?>">
                </div>

                <div class="container-desconto linha">
                    <label>Desconto:</label>
                    <input type="text" name="txtDesconto" value="<?=isset($desconto)?$desconto:null?>">
                </div>

                <input type="submit" value="salvar" class="salvar">
            </form>
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <td>Descrição</td>
                    <td>Imagem</td>
                    <td>Preço</td>
                    <td>Desconto</td>
                    <td>Opções</td>
                </tr>
                <?php

                    require_once('controller/controllerProdutos.php');

                    $dados = listarProdutos();

                    foreach($dados as $produto){

                        $imagem = $produto['imagem'];

                ?>
                <tr>
                    <td><?=$produto['descricao']?></td>
                    <td class="td-imagem">
                        <img src="<?=DIRECTORY_FILE_UPLOAD.$imagem?>" alt="">
                        
                    </td>
                    <td><?=$produto['preco']?></td>
                    <td><?=$produto['desconto']?></td>
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
                ?>
            </table>
        </div>
    </div>
</body>


<!-- create table tblprodutos(

	#int ==> tipo de dados
    #not nul ==> é um atributo que não pode ficar vazio
    #auto_increment ==> será gerenciado automaticamente pelo banco de dados
    #primary key ==> chave principal
	idproduto int not null auto_increment primary key,
    
    #varchar ==> equivalente a String
    descricao varchar(100) not null,
    
    imagem varchar(50) not null,
    
	preco decimal(10) not null,
    
    desconto decimal(5)
);

alter table tblusuarios modify senha varchar(100) not null;
show tables;

#Comando para declarar os atributos que receberão os valores
insert into tblprodutos(descricao, imagem, preco, desconto)
	#valores que serão recebidos pelos atributos
	values('Jogo Marvel Spider-Man: Miles Morales - PS4',
			'ro0ot', 
			10.0,
            1); -->

</html>