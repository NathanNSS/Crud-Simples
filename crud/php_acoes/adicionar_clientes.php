<?php
session_start();
//conexão com Banco
require_once "conectBD.php";

function limpar($inputs){
    global $linkBD;
    $var = mysqli_escape_string($linkBD,$inputs);
    $var = htmlspecialchars($var);
    return $var;
}
if(isset($_POST["cad_cliente"])){
    if(!empty($_POST['nome']) and ($_POST['sobrenome']) and ($_POST['email']) and ($_POST['idade'])){    
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');
        
        $idUsuario = limpar($_POST['idUsuario']);
        $nome = limpar($_POST['nome']);
        $sobrenome = limpar($_POST['sobrenome']);
        $email = limpar($_POST['email']);
        $idade = limpar($_POST['idade']);


        $sqlCreatCliente = "INSERT INTO clientes (fk_usuario,nome, sobrenome, email, idade,data) 
                            VALUES ('$idUsuario','$nome','$sobrenome','$email','$idade','$data')";
        if(mysqli_query($linkBD,$sqlCreatCliente)){
            $_SESSION['menssagem'] = "Cliente &nbsp;<b>$nome</b>&nbsp; foi Cadastrado com Sucesso<br>";
            mysqli_close($linkBD);
            header("location: ../index.php");
        }
        else{
            $_SESSION['menssagem'] = "Erro ao Cadastrar o Cliente <b>$nome</b><br>". mysqli_error($linkBD);
            mysqli_close($linkBD);
        }
    }
    else{
        $_SESSION['menssagem'] = "Prencha Todos os Campos Antes de Enviar !";
        mysqli_close($linkBD);
        header("location: ../index.php");
    }    
}