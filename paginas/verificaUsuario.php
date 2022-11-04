<?php
    $url = $_SERVER['PHP_SELF'];

    //VERIFICA SE ESTA NA PAGINA INDEX E LOGADO PARA REDIRECIONAR
    if(strpos($url, "index") == true && @$_SESSION['logado'] == true)
    {
        header("location: paginas/lobby.php");

    }
    elseif (@$_SESSION['logado'] != true && strpos($url, "index") != true) 
    {
        header("location: ../index.php");
    }
  