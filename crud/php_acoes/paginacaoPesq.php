<?php 
function limpar($inputs){
    global $linkBD;
    $var = mysqli_escape_string($linkBD,$inputs);
    $var = htmlspecialchars_decode($var);
    $var = str_replace("\\","",$var);
    $var = str_replace(";","",$var);
    return $var;
}

$pagina = limpar(isset($_GET['pagina'])) ? $_GET['pagina']:1;

if(isset($_GET['pesquisa'])){
    $pesquisa = limpar($_GET['pesquisa']);
    $pesq = " AND nome LIKE '%$pesquisa%' ";
    $pesquisar = "&pesquisa=$pesquisa";
}
else{
    $pesquisa = "";
    $pesq = "";
    $pesquisar = "";
}

$sqlListagemBD = "SELECT nome, sobrenome, email, idade, data FROM clientes  where fk_usuario = $id $pesq ";

$resultado = mysqli_query($linkBD, $sqlListagemBD);

$totalDados = mysqli_num_rows($resultado); 

$itemPagina = 5;

$totalPagina = ceil($totalDados/$itemPagina);

$inicio = ($itemPagina*$pagina)-$itemPagina;

$sqlListPagina = "SELECT id, nome, sobrenome, email, idade, data FROM clientes where fk_usuario = $id $pesq ORDER BY data desc limit $inicio, $itemPagina";

$resultadoPagina = mysqli_query($linkBD,$sqlListPagina);

$PP = mysqli_num_rows($resultadoPagina);

$paginaSeguinte = $pagina + 1;
$paginaAnterio = $pagina - 1;


?>