<?php
  include "conexao.php";
 
  if($_POST['posicao'] != NULL && $_POST['idPartida'] != NULL  && $_POST['idUsuario'] != NULL && $_POST['idAdversario'] != NULL)
  {
        $comando = "INSERT INTO jogadas (id_partida, posicao, id_usuario) VALUES ({$_POST['idPartida']}, {$_POST['posicao']}, {$_POST['idUsuario']})";
        $pre = $conexao->prepare($comando);
       $res  = $pre->execute(); //Retorna se foi registrado com sucesso

       if($res == 1 )
       {
        //Mudando turno (id jogador no campo turno)
        $comando = "UPDATE partidas SET turno ={$_POST['idAdversario']} WHERE idPartida = {$_POST['idPartida']} ";
        $pre = $conexao->prepare($comando);
         echo $pre->execute(); 

       }

  }

 
    
    //    $pre = $conexao->prepare($comando);
     //   $pre->execute();