<?php
    include "conexao.php";
    session_start();
    if($_POST['jogadorVisitante'] != NULL )
    {
       
        $comando = "INSERT INTO `partidas` (`jogadorCasa`, `jogadorVisitante`) VALUES ('{$_SESSION['idUsuario']}', '{$_POST['jogadorVisitante']}')";
    
        $pre = $conexao->prepare($comando);
        $pre->execute();
       
       
    }
