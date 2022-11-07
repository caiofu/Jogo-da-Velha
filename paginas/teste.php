<?php
include "conexao.php";
//VERIFICAR SE PLAYER GANHOU
$posicoesVitoriosas = [
   [1,2,3],
   [4,5,6],
   [7,8,9],
   [1,4,7],
   [2,5,8],
   ];
   
$verifica = $conexao->prepare("SELECT * FROM jogadas jo INNER JOIN partidas pa ON jo.id_partida = pa.idPartida WHERE id_partida = 7 ");
$verifica->execute();
$jogadasUsuario =[];
$jogadasAdversario = [];
$vencedor;

while($v = $verifica->fetch(PDO::FETCH_ASSOC))
{
   echo $v['jogadorCasa']." - ".$v['jogadorVisitante']."<br>";
   if($v['jogadorCasa'] == $v['id_usuario'])
   {
       array_push($jogadasUsuario,$v['posicao']);
   }
   else 
   {
       array_push($jogadasAdversario,$v['posicao']);
   }
}

var_dump($jogadasUsuario);
echo "<br>";
var_dump($jogadasAdversario);


for($i = 0; $i < count(  $posicoesVitoriosas); $i++)
{
   $contadorUsuario =0;
   $contadorAdversario = 0;
   for ($j=0; $j < count($posicoesVitoriosas[$i]); $j++) 
   { 

       if( in_array($posicoesVitoriosas[$i][$j],   $jogadasUsuario ) ==1)
       {
           $contadorUsuario++;
       }
       elseif (in_array($posicoesVitoriosas[$i][$j],   $jogadasAdversario ) ==1) 
       {
           $contadorAdversario++;
       }
   }

   if($contadorUsuario == 3)
   {
       $vencedor = 6;
       break;
   }
   elseif($contadorAdversario == 3)
   {
       $vencedor = 2;
       break;
   }
   else
   {
       $vencedor = 0;
   }

}
echo "vencedor: ".$vencedor;
//FIM DA VERIFICAÇAO DE VENCEDOR 