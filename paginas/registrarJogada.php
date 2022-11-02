<?php
  include "conexao.php";
 
  if($_POST['linha'] != NULL && $_POST['coluna'] != NULL)
  {
        $comando = "INSERT INTO `partidas` (`linha`, `coluna`, 'id_partida', 'id_usuario') VALUES ({$_POST['linha']}, {$_POST['coluna']}, {$_POST['idPartida']}, {$_POST['idJogador']})";
        $pre = $conexao->prepare($comando);
        $pre->execute();
    
  }

 
    
    //    $pre = $conexao->prepare($comando);
     //   $pre->execute();