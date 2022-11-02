<?php
   
var_dump($_SESSION);
    if(@$_SESSION['logado'] == true)
    {
        header("location: paginas/lobby.php");
    }