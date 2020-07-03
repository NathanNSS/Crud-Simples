<?php 
session_start();
// Conexão
require_once "conectBD.php";

function limpar($inputs){
    global $linkBD;
    $var = mysqli_escape_string($linkBD,$inputs);
    $var = htmlspecialchars_decode($var);
    $var = str_replace("\\","",$var);
    return $var;
}

if(isset($_POST['edit_cliente'])){
    if(!empty($_POST['nome']) and ($_POST['sobrenome']) and ($_POST['email']) and ($_POST['idade'])){
        $nomeAntigo = $_SESSION['edit_nome'];
        $id = limpar($_POST['id']);
        $nome = limpar($_POST['nome']);
        $sobrenome = limpar($_POST['sobrenome']);
        $email = limpar($_POST['email']);
        $idade = limpar($_POST['idade']);
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');
        
        $sqlEdit = "UPDATE clientes SET  nome = '$nome', sobrenome = '$sobrenome', email  ='$email', idade = '$idade', data = '$data' WHERE id = '$id'";

        if(mysqli_query($linkBD,$sqlEdit)){
            $_SESSION['menssagem'] = "<b>Editado</b>";
            mysqli_close($linkBD);
            header ("location: ../index.php");
        }
        else{
            $_SESSION['menssagem'] = "Não Foi Possivel Editar o Cliente <b>$nomeAntigo</b>";
            mysqli_close($linkBD);
            header ("location: ../index.php");
        }
    }
    else{
        $_SESSION['menssagem'] = "Prencha Todos os Campos Antes de Enviar !";
        mysqli_close($linkBD);
        header ("location: editar.php?id='$id'");

    }
}
if(isset($_POST['limpar_campos'])){
    $_SESSION['menssagem'] = "Campos Limpo";
    mysqli_close($linkBD);
    header  ("location: editar.php?id='$id'");
}


?>