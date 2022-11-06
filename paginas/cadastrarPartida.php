<?php
    include "conexao.php";
    session_start();
    if($_POST['jogadorVisitante'] != NULL )
    {
       $dataAtual = date("Y-m-d H:i:s");
        $comando = "INSERT INTO `partidas` (`jogadorCasa`, `jogadorVisitante`, dataCriacao, turno) VALUES ('{$_SESSION['idUsuario']}', '{$_POST['jogadorVisitante']}', '{$dataAtual}','{$_SESSION['idUsuario']}')";
    
        $pre = $conexao->prepare($comando);
        $pre->execute();

        header('location: lobby.php');
       
       
    }
