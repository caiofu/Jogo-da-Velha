<?php
  include "conexao.php";
 
  if($_POST['posicao'] != NULL && $_POST['idPartida'] != NULL  && $_POST['idUsuario'] != NULL)
  {
        $comando = "INSERT INTO jogadas (id_partida, posicao, id_usuario) VALUES ({$_POST['idPartida']}, {$_POST['posicao']}, {$_POST['idUsuario']})";
        $pre = $conexao->prepare($comando);
       echo $pre->execute(); //Retorna se foi registrado com sucesso

  }

 
    
    //    $pre = $conexao->prepare($comando);
     //   $pre->execute();