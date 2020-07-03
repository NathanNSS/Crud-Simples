<?php
session_start();
//conexão com Banco
require_once "php_acoes/conectBD.php";
//Menssagem
require_once "php_acoes/menssagens.php";
$id = $_SESSION['id_usuario'];
//Paginação conf com Pesquisas
require_once "php_acoes/paginacaoPesq.php";

$status = $_SESSION['logado'];

//Pegando o id do usuario que fez o login e buscando no banco
$sqlBuscUser = "SELECT * FROM usuario WHERE id = '$id'";
$resultado = mysqli_query($linkBD, $sqlBuscUser);
$dados = mysqli_fetch_array($resultado);

// verificação de Autorização 
if(!isset($_SESSION['logado']) || (!$status == true)){
    header("location:login/login.php");
    $_SESSION['menssagem'] = "Acesso Negado";
    mysqli_close($linkBD);
}
else{
    $status = "logado";
   
}


// Sai da sessão ao clicar no botão
if(isset($_POST['Sair'])){
    session_unset();
    session_destroy();
    mysqli_close($linkBD);
    //$_SESSION['menssagem'] = "Thau ".$dados['nome']." :)";
    header('Location: login/login.php');
    
}

function formataData($data){
    $array1 = explode(" ",$data);
    $array2 = $array1[0];
    $array3 = $array1[1];
    $array2 = explode("-",$array2);
    $array3 = explode(":",$array3);
    $novaData = $array2[2]."/".$array2[1]."/".$array2[0]." ".$array3[0].":".$array3[1];
    return $novaData;
} 

?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Crud</title>
    </head>
    <body>
        <div class="right">
            <form  action="<?php echo $_SERVER['PHP_SELF']?>" class="login-form"  method="POST">

                <button type="submit" class="btn red z-depth-5" name="Sair"><i class="material-icons">exit_to_app</i></button>
            
            </form>
        </div>
        <div class="row">
            <div class=" col s12 m6 push-m3">
                <div class="row nav-wrapper">
                    <div class="col l12 m6 push-m3">
                        <h2 class="col l12 ">Clientes
                        <form class="col l6  right " action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
                                    <div class="input-field">
                                        <input id="search" class="" value="<?php echo $pesquisa; ?>" type="search" name="pesquisa">
                                        <label class="label-icon " for="search"><i class="material-icons ">search</i></label>
                                        <i class="material-icons ">close</i>    
                                    </div>  
                                </form>                    
                        </h2>
                    </div>
                </div>
                <!-- TAbela Cliente -->
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>E-Mail</th>
                            <th>Idade</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sqlListagemBD = "SELECT * FROM clientes WHERE fk_usuario = $id ORDER BY data desc";
                            $resultado = mysqli_query($linkBD, $sqlListagemBD);
                            if(mysqli_num_rows($resultadoPagina) > 0){

                            while ($dados = mysqli_fetch_array($resultadoPagina)) {
                            
                        ?>
                        <tr>
                            <td><?php echo $dados['nome']; ?></td>
                            <td><?php echo $dados['sobrenome']; ?></td>
                            <td><?php echo $dados['email']; ?></td>
                            <td><?php echo $dados['idade']; ?></td>
                            <td><?php echo formataData($dados['data']); ?></td>
                            <td><a href="php_acoes/editar.php?id=<?php echo $dados['id'];?>" data-target="modal_Edit_Cliente" class="btn-floating orange modal-trigger z-depth-2"><i class="material-icons">edit</i></a></td>
                            <td><a href="php_acoes/delete.php?id=<?php echo $dados['id'];?>" data-target="modal_Excl_Cliente" class="btn-floating red modal-trigger z-depth-2"><i class="material-icons">delete</i></a></td>
                            <!-- <td><a href="php_acoes/receID.php?id=</?php echo $dados['id'];?>" data-target="modal_Excl_Cliente" class="btn-floating red modal-trigger "><i class="material-icons">delete</i></a></td> -->
                        </tr>
                        <tr>
                            <td>
                        <?php 
                            }
                            }
                            else{$_SESSION['menssagem'] = "Sem Dados No Banco :(";}
                            
                            
                        ?>
                    </tbody>
                </table>

                
                <a class="waves-effect waves-light btn modal-trigger z-depth-2" name="modalADC" href="#modal_Add_Cliente">Adicionar Clientes</a>

                
                <div class="center">    
                    <ul class="pagination">
                        <?php if($paginaAnterio != 0){ ?>
                            
                        <li class="waves-effect"><a href="Index.php?pagina=<?php echo $paginaAnterio; echo $pesquisar;?>"><i class="material-icons">chevron_left</i></a></li>
                        
                        <?php }?>

                        <?php for($i = 1; $i < $totalPagina + 1; $i++){ $estilo = ""; if($i == $pagina ){ $estilo = "active z-depth-2";}?>
                                
                        <li class="<?php echo $estilo?>"><a href="Index.php?pagina=<?php echo $i; echo$pesquisar?>"><?php echo $i?></a></li>
                        
                        <?php } ?>
                        
                        <?php if($paginaSeguinte <= $totalPagina){ ?>

                        <li class="waves-effect"><a href="Index.php?pagina=<?php echo $paginaSeguinte; echo $pesquisar;?>"><i class="material-icons ">chevron_right</i></a></li>

                        <?php }?>
                        
                    </ul>
                </div>
                <!-- Modal Adicionar Clientes --> 
                <div id="modal_Add_Cliente" class="modal">
                    <div class="modal-content">

                        <h3 class="light">Adicionar Clientes</h3>

                        <form action="php_acoes/adicionar_clientes.php" method="POST">
                            <input type="hidden" value="<?php echo $id?>" name="idUsuario" >
                            <input type="text" name="nome" id="nome" autofocus>
                            <label for="nome">Nome</label>
                            <br><br>
                            <input type="text" name="sobrenome" id="sobrenome" >
                            <label for="sobrenome">Sobrenome</label>
                            <br><br>
                            <input type="email" name="email" id="email">
                            <label for="email">E-mail</label>
                            <br><br>
                            <input type="text" name="idade" id="idade">
                            <label for="idade">Idade</label>
                            
                            <div class="modal-footer">
                            <button class="btn green modal-close effect" type="submit" name="cad_cliente">Cadastrar</button>
                            <button class="btn red" type="reset">Limpar</button>
                            </div>

                        </form>

                    </div>
                </div>
                <!-- Modal Editar Clientes >> !!OBS Arrumar!! -->
                <div id="modal_Edit_Cliente--" class="modal">
                    <div class="modal-content">

                        <h3 class="light">Editar Cliente</h3>

                        <form action="php_acoes/adicionar_clientes.php" method="POST">
                            <input type="hidden" name="id" id="id" value="<?php $_SESSION['idselec']; ?>">
                            <input type="text" name="nome" id="nome" autofocus>
                            <label for="nome">Nome</label>
                            <br><br>
                            <input type="text" name="sobrenome" id="sobrenome" >
                            <label for="sobrenome">Sobrenome</label>
                            <br><br>
                            <input type="email" name="email" id="email">
                            <label for="email">E-mail</label>
                            <br><br>
                            <input type="text" name="idade" id="idade">
                            <label for="idade">Idade</label>
                            
                            <div class="modal-footer">
                            <button class="btn green modal-close effect" type="submit" name="cad_cliente">Cadastrar</button>
                            <button class="btn red modal-close effect" type="reset">Cancelar</button>
                            </div>

                        </form>

                    </div>

                   
                </div>
                <!-- Modal Confirma Exclusão >> !!OBS Arrumar!! -->
                <div id="modal_Excl_Cliente--" class="modal">
                    <div class="modal-content">
        
                        <h3 class="light">Deja Mesmo Excluir Este Cliente</h3>
                        <form method="POST" action="php_acoes/delete.php">
                            <input type="text" name="id" id="id" value="<?php require_once 'php_acoes/receID.php'?>">
                        
                            <div class="modal-footer">
                                    <button href="php_acoes/delete.php" class="btn green modal-close effect" type="submit" name="conf_excl">Excluir</button>
                                    <button class="btn red modal-close effect" type="reset">Cancelar</button>
                            </div>
                      
                        </form>  

                    </div>

                   
                </div>
                
            </div>
        </div>
        





        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            const elemsModal = document.querySelectorAll(".modal");
            const instancesModal = M.Modal.init(elemsModal,{

            });
        </script>
    </body>
</html>