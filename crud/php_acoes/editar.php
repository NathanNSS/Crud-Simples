<?php
session_start();
// Menssagens
require_once "menssagens.php";

// Conexão com Banco
include_once "conectBD.php";

function limpar($inputs){
    global $linkBD;
    $var = mysqli_escape_string($linkBD,$inputs);
    $var = htmlspecialchars_decode($var);
    $var = str_replace("\\","",$var);
    return $var;
}

if(isset($_GET['id'])){
    if(!empty($_GET['id'])){

        $id =  mysqli_escape_string($linkBD,trim($_GET['id']));

        $sqlBusca = "SELECT * FROM  clientes WHERE id = '$id' ";
        $resultado = mysqli_query($linkBD, $sqlBusca);
        $dados = mysqli_fetch_array($resultado);
    
        if(!empty($dados['nome']) and ($dados['sobrenome']) and ($dados['email']) and ($dados['idade'])){
            $id = limpar($dados['id']);
            $nome = limpar($dados['nome']);
            $sobrenome = limpar($dados['sobrenome']);
            $email = limpar($dados['email']);
            $idade = limpar($dados['idade']);

            $_SESSION['edit_nome'] = $nome;
        }else{
            $id = str_replace("\'","",$id);
            $nome = "";
            $sobrenome = "";
            $email = "";
            $idade = "";

        }    
    }
    else{
        $_SESSION['menssagem'] = "Não Recebemos o ID do Cliente";
    }
}
else{
    $_SESSION['menssagem'] = "Não Recebemos o ID do Cliente";
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

    </head>
    <body>
        <div class="row">
            <div class=" col s12 m6 push-m3">
                <form action="update.php" method="POST">
                    <h2>Editar Cliente</h2>
                    <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
                    <br><br>
                    <input type="text" name="nome" id="nome" autofocus value="<?php echo $nome;?>">
                    <label for="nome">Nome</label>
                    <br><br>
                    <input type="text" name="sobrenome" id="sobrenome" value="<?php echo $sobrenome;?>">
                    <label for="sobrenome">Sobrenome</label>
                    <br><br>
                    <input type="email" name="email" id="email" value="<?php echo $email;?>">
                    <label for="email">E-mail</label>
                    <br><br>
                    <input type="text" name="idade" id="idade" value="<?php echo $idade;?>">
                    <label for="idade">Idade</label>
                    <br><br>
                    <button class="btn green" type="submit" name="edit_cliente">Editar</button>
                    <button class="btn red" type="submit" name="limpar_campos">Limpar</button>
                    <a href="../index.php" class="btn-floating orange right" ><i class="material-icons">reply</i></a>
                    

                </form>                
               
                
            </div>
        </div>
        
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </body>
</html>