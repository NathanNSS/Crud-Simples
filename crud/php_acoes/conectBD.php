<?php

$host = "localhost";
$user = "root";
$pass = "";
$BDname = "crud_m";
$linkBD = mysqli_connect($host,$user,$pass,$BDname);
mysqli_set_charset($linkBD,"utf8");
    mysqli_set_charset($linkBD,"utf-8");
    if(!$linkBD){
        die("Falha Na Conexão: " . mysqli_connect_error());
    }
    else{
       $_SESSION['statusBD'] = "<br> Conectado com Sucesso! <br>";
    }


?>