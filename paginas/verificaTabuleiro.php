<?php
    include "conexao.php";
 
    if($_POST['idPartida'] != NULL)
    {
        $comando = "SELECT * FROM jogadas WHERE id_Partida = {$_POST['idPartida']}";
        
        $pre = $conexao->prepare($comando);
        $pre->execute(); 

        $ln = $pre->fetch(PDO::FETCH_ASSOC);
       //Resposta
       
    }