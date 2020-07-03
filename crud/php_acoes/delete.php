<?php
session_start();
require_once "conectBD.php";
 
if(isset($_GET['id'])){
    if(!empty($_GET['id'])){
        
        $id =  mysqli_escape_string($linkBD,$_GET['id']);
        echo $id;
        $sqlDelete = "DELETE FROM clientes WHERE id = '$id'";
        $sqlBusca = "SELECT * FROM clientes WHERE id = '$id'";
        $resultado = mysqli_query($linkBD, $sqlBusca);
        $dados = mysqli_fetch_array($resultado);
        var_dump($dados);
        if(mysqli_query($linkBD, $sqlDelete)){
            mysqli_close($linkBD);
            $_SESSION['menssagem'] = "Cliente &nbsp;<b>".$dados['nome']."</b>&nbsp; Foi Excluido com Sucesso<br";
            header("location: ../index.php");
            
        }
        else{
            $_SESSION['menssagem'] = "Erro ao Excluir o Cliente &nbsp;<b>".$dados['nome']."</b>&nbsp; !";
            mysqli_close($linkBD);
            header("location: ../index.php");

        }
    }
    else{
        mysqli_close($linkBD);
        session_unset();
        header("location: ../index.php");
        
    }    
}else{
    mysqli_close($linkBD);
    session_unset();
    header("location: ../index.php");
    }

if(isset($_POST['conf_excl'])){
    $id = $_POST['id'];
    echo $id;
}
else{
    "não chegou";
}