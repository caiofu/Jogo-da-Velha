<?php
  include "conexao.php";
  
  if($_POST['linha'] != NULL && $_POST['coluna'] != NULL)
  {
    $comando = "INSERT INTO `partidas` (`linha`, `coluna`, 'id_partida', 'id_usuario') VALUES ({$_POST['linha']}, {$_POST['linha']}, {$_POST['linha']})";
  }
 
    
    //    $pre = $conexao->prepare($comando);
     //   $pre->execute();