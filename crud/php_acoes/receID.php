<?php
//conexão com Banco
require_once "conectBD.php";
//Menssagem
require_once "menssagens.php";


if(isset($_GET['id'])){
    $_SESSION['idExcl'] = $_GET['id'];
    echo $_SESSION['idExcl'];
}
else{
    echo "Não Recebeu o Id";
    echo $_SESSION['idExcl'];
}
