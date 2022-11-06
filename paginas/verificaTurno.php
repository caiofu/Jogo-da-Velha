<?php
    include "conexao.php";
 
    if($_POST['idPartida'] != NULL && $_POST['idAdversario'] != NULL)
    {
        $comando = "SELECT turno FROM partidas WHERE idPartida = {$_POST['idPartida']}";
        
        $pre = $conexao->prepare($comando);
        $pre->execute(); 

        $ln = $pre->fetch(PDO::FETCH_ASSOC);
        echo $ln['turno'];
       
    }