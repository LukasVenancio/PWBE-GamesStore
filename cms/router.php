<?php
/*Arquuivo para segmentar as ações encaminhadas pela view.
Será responsável por encaminhar as solicitações para a controller. */

require_once('model/config.php');

require_once('controller/controllerContatos.php');
require_once('controller/controllerCategorias.php');
require_once('controller/controllerUsuarios.php');
require_once('controller/controllerProdutos.php');



$action = (string) null;
$component = (string) null;

/*Verificação da requisição da viewer. */
if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET'){

    $component = strtolower($_GET['component']);
    $action = strtolower($_GET['action']);

    /*Verificação da página que fez a requisição. */
    if($component == 'contatos'){

        /*Verificação da ação requirida pela página. */
        if($action == 'deletar'){

            $id = $_GET['id'];

            $resposta = excluirContato($id);

            if(is_bool($resposta)){

                if($resposta){
                   
                    echo("<script>
                            alert('Registro excluído com sucesso!')
                            window.location.href = 'contatos.php'  
                        </script>");
                }
            
            }elseif(is_array($resposta)){
                
                echo("<script>
                            alert('".$resposta['message']."')
                        </script>");
            }
        }

    }elseif($component == 'categorias'){

        if($action == 'inserir'){

            /*Executando função da controller. */
            $resposta = inserirCategoria($_POST);

            if(is_bool($resposta)){

                if($resposta){
                    
                    echo("<script>
                            alert('Registro inserido com sucesso!')
                            window.location.href = 'categorias.php'
                        </script>");
                }
                
            }elseif(is_array($resposta)){
                    echo("<script>
                            alert('".$resposta['message']."')
                            window.history.back()
                        </script>");
                
            }
            
        }elseif($action == 'deletar'){

            $id = $_GET['id'];

            $resposta = excluirCategoria($id);

            if(is_bool($resposta)){

                if($resposta){
                    echo("<script>
                                alert('Registro excluído com sucesso!')
                                window.location.href = 'categorias.php'
                            </script>");
                }
            
            }elseif(is_array($resposta)){
                echo("<script>
                            alert('".$resposta['message']."')
                            window.history.back()
                        </script>");
            }
        
        }elseif($action == 'buscar'){
            
            $id = $_GET['id'];

            $dados = buscarCategoria($id);

            /*Ativando o uso de variáveis de sessão para que seja possível
            levar os dados de volta ao arquivo 'categorias.php' já que, o
            arquivo router não possui retorno (lembrando que as variáveis de sessão somente
            são destruídas quando fechamos o navegador ou então quando as 
            destruímos manualmente).*/
            session_start();

            /*Criando uma variável de sessão que carregará os dados que retornaram
            do Data Base, e será acessada no arquivo 'categorias.php'. */
            $_SESSION['dadosCategorias'] = $dados;

            /*Para evitar que a tela do usário pisque, fazemos um import
            da página principal, fazendo com que ela seja reconstruída
            com as variáveis de sessão já criadas.*/
            require_once('categorias.php');
            

            
        }elseif($action == 'editar'){
            
            $id = $_GET['id'];

            $dados = $_POST;
            
            /*Executando função da controller. */
            $resposta = atualizarCategoria($dados, $id);

            if(is_bool($resposta)){

                if($resposta){
                    
                    echo("<script>
                            alert('Registro atualizado com sucesso!')
                            window.location.href = 'categorias.php'
                        </script>");
                }

            }elseif(is_array($resposta)){
                    echo("<script>
                            alert('".$resposta['message']."')
                            window.history.back()
                        </script>");
                
            }
        }

    }elseif($component == 'usuarios'){

        if($action == 'inserir'){
            
            $resposta = inserirUsuarios($_POST);

            if(is_bool($resposta)){

                if($resposta){
                    
                    echo("<script>
                            alert('Registro inserido com sucesso!')
                            window.location.href = 'usuarios.php'
                        </script>");
                }

            }elseif(is_array($resposta)){
                    echo("<script>
                            alert('".$resposta['message']."')
                            window.history.back()
                        </script>");
                
            }
            
        
        }elseif($action == 'deletar'){

            $id = $_GET['id'];

            $resposta = excluirUsuarios($id);

            if(is_bool($resposta)){

                if($resposta){
                    echo("<script>
                            alert('Registro excluído com sucesso!')
                            window.location.href = 'usuarios.php'
                        </script>");
                }
            
            }elseif(is_array($resposta)){
                echo("<script>
                        alert('".$resposta['message']."')
                        window.history.back()
                    </script>");
            }

        
        }elseif($action == 'buscar'){

            $id = $_GET['id'];

            $dados = buscarUsuarios($id);

            session_start();

            $_SESSION['dadosUsuarios'] = $dados;

            require_once('usuarios.php');
        
        }elseif($action == 'editar'){

            $id = $_GET['id'];
            $dados  = $_POST;

            $resposta = atualizarUsuarios($dados, $id);
            
            if(is_bool($resposta)){

                if($resposta){
                    
                    echo("<script>
                            alert('Registro atualizado com sucesso!')
                            window.location.href = 'usuarios.php'
                        </script>");
                }

            }elseif(is_array($resposta)){
                    echo("<script>
                            alert('".$resposta['message']."')
                            window.history.back()
                        </script>");
            }
        }
    
    }elseif($component == 'produtos'){

        if($action == 'inserir'){

            $dados = array(
                $_POST,
                'file' => $_FILES
            );

            $resposta = inserirProdutos($dados);

            if(is_bool($resposta)){

                if($resposta){
                    echo("<script>
                            alert('Registro inserido com sucesso!')
                            window.location.href = 'produtos.php'
                        </script>");
                }

            }elseif(is_array($resposta)){
                echo("<script>
                            alert('".$resposta['message']."')
                            window.history.back()
                        </script>");
            }
        
        }elseif($action == 'deletar'){

            $produto = array(
                "id"    => $_GET['id'],
                "image" => $_GET['image']
            );

            $resposta = excluirProdutos($produto);

            if(is_bool($resposta)){

                if($resposta){
                    echo("<script>
                            alert('Registro excluído com sucesso!')
                             window.location.href = 'produtos.php'
                         </script>");
                }
            
            }elseif(is_array($resposta)){
                echo("<script>
                        alert('".$resposta['message']."')
                        window.history.back()
                    </script>");
            }
        
        }elseif($action == 'buscar'){

            $id = $_GET['id'];

            $dados = buscarProdutos($id);

            session_start();
            $_SESSION['dadosProdutos'] = $dados;

            require_once('produtos.php');

        }elseif($action == 'editar'){

            $dados = array(
                $_POST,
                "file"          => $_FILES,
                "id"            => $_GET['id'],
                "imagemAntiga"  => $_GET['imagem'],
            );

            $resposta = atualizarProdutos($dados);

            if(is_bool($resposta)){

                if($resposta){
                    
                    echo("<script>
                            alert('Registro atualizado com sucesso!')
                            window.location.href = 'produtos.php'
                        </script>");
                }

            }elseif(is_array($resposta)){
                    echo("<script>
                            alert('".$resposta['message']."')
                            window.history.back()
                        </script>");
                
            }
        }
        
    }
}




?>