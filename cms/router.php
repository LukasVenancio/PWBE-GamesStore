<?php
/*Arquuivo para segmentar as ações encaminhadas pela view.
Será responsável por encaminhar as solicitações para a controller. */

require_once('./controller/controllerContatos.php');

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

    }

}




?>