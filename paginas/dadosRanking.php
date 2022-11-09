<?php

include "conexao.php";

//$comando = "SELECT turno FROM partidas WHERE idPartida = {$_POST['idPartida']}";
        
$comando = "SELECT * FROM jogadores WHERE vitoria > 0 ORDER BY vitoria DESC LIMIT 30";
              
$pre = $conexao->prepare($comando);
$pre->execute(); 
$colocacao = 0;
$dados = Array();
while ($ln = $pre->fetch(PDO::FETCH_ASSOC))
{
    array_push($dados,['idJogador' => $ln['idJogador'],'nome' => $ln['usuario'], 'vitoria' => $ln['vitoria'], 'derrota' => $ln['derrota'], 'empate' => $ln['empate']]);
}

//Resposta
echo json_encode($dados, JSON_PRETTY_PRINT);
