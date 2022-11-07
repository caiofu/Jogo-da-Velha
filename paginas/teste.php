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
  $verifica = $conexao->prepare("SELECT *  FROM jogadas WHERE id_partida = 7");
  $verifica->execute();

  
  $jogadasUsuario =[];
         $jogadasAdversario = [];

         while($v = $verifica->fetch(PDO::FETCH_ASSOC))
         {
            if($v['id_usuario'] == 6)
            {
                array_push($jogadasUsuario,$v['posicao']);
            }
            elseif ($v['id_usuario'] == 2)
            {
                array_push($jogadasAdversario,$v['posicao']);
            }
         } 
         for($i = 0; $i < count(  $posicoesVitoriosas); $i++)
         {
           $contador =0;
            for ($j=0; $j < count($posicoesVitoriosas[$i]); $j++) 
            { 
               
             if( in_array($posicoesVitoriosas[$i][$j],   $jogadasUsuario ) ==1)
             {
                $contador++;
             }
            }
           if($contador == 3)
           {
            echo "vencer";
           }
            
         }

         for($i = 0; $i < count(  $posicoesVitoriosas); $i++)
         {
           $contador =0;
            for ($j=0; $j < count($posicoesVitoriosas[$i]); $j++) 
            { 
               
             if( in_array($posicoesVitoriosas[$i][$j],   $jogadasAdversario ) ==1)
             {
                $contador++;
             }
            }
           if($contador == 3)
           {
            echo "vencer";
           }
            
         }
         /*

 $posicaoArray = [1,2,5,3];
 for($i = 0; $i < count($te); $i++)
 {
   $contador =0;
    for ($j=0; $j < count($te[$i]); $j++) 
    { 
       
     if( in_array($te[$i][$j],  $posicaoArray ) ==1)
     {
        $contador++;
     }
    }
   if($contador == 3)
   {
    echo "vencer";
   }
    
 }*/