<?php
    include "conexao.php";
 
    if($_POST['idPartida'] != NULL && $_POST['idAdversario'] != NULL)
    {
        $comando = "SELECT turno FROM partidas WHERE idPartida = {$_POST['idPartida']}";
        
        $pre = $conexao->prepare($comando);
        $pre->execute(); 

        $ln = $pre->fetch(PDO::FETCH_ASSOC);
       // echo $ln['turno'];
        //VERIFICAR SE PLAYER GANHOU
        $posicoesVitoriosas = [
            [1,2,3],
            [4,5,6],
            [7,8,9],
            [1,4,7],
            [2,5,8],
            ];
            
        $verifica = $conexao->prepare("SELECT * FROM jogadas jo INNER JOIN partidas pa ON jo.id_partida = pa.idPartida WHERE id_partida = {$_POST['idPartida']} ");
        $verifica->execute();
        $jogadasUsuario =[];
        $jogadasAdversario = [];
        $vencedor= 0;

        while($v = $verifica->fetch(PDO::FETCH_ASSOC))
        {
            if($v['jogadorCasa'] == $v['id_usuario'])
            {
                array_push($jogadasUsuario,$v['posicao']);
                $jogadorCasa = $v['id_usuario'];
            }
            elseif ($v['jogadorVisitante'] == $v['id_usuario'])
            {
                array_push($jogadasAdversario,$v['posicao']);
                $jogadorVisitante = $v['id_usuario'];
            }
        }

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
                $vencedor = $jogadorCasa;
                break;
            }
            elseif($contadorAdversario == 3)
            {
                $vencedor = $jogadorVisitante;
                break;
            }
            else
            {
                $vencedor = 0;
            }

        }
        //FIM DA VERIFICAÇAO DE VENCEDOR 
        
        $dados = ["turno" =>$ln['turno'], "vencedor" => $vencedor];
         //Resposta
         echo json_encode($dados, JSON_PRETTY_PRINT);
       
    }