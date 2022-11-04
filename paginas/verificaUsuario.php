<?php

    if(@$_SESSION['logado'] == true)
    {
        header("location: paginas/lobby.php");
    }