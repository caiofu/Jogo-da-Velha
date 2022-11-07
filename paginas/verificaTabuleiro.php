<?php
    include "conexao.php";
 
    if($_POST['idPartida'] != NULL && $_POST['idUsuario'] != NULL && $_POST['idAdversario'] != NULL)
    {
        //VERIFICAR SE PLAYER GANHOU
        $posicoesVitoriosas = [
            [1,2,3],
            [4,5,6],
            [7,8,9],
            [1,4,7],
            [2,5,8],
            ];
        $verifica = $conexao->prepare("SELECT * FROM jogadas WHERE id_partida = {$_POST['idPartida']} ");
        $verifica->execute();
        $jogadasUsuario =[];
        $jogadasAdversario = [];
        $vencedor;

        while($v = $verifica->fetch(PDO::FETCH_ASSOC))
        {
            if($v['id_usuario'] == $_POST['idUsuario'])
            {
                array_push($jogadasUsuario,$v['posicao']);
            }
            elseif ($v['id_usuario'] == $_POST['idAdversario'])
            {
                array_push($jogadasAdversario,$v['posicao']);
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
                $vencedor = $_POST['idUsuario'];
                break;
            }
            elseif($contadorAdversario == 3)
            {
                $vencedor = $_POST['idUsuario'];
                break;
            }
            else
            {
                $vencedor = 0;
            }

        }
        //FIM DA VERIFICAÇAO DE VENCEDOR 

        $comando = "SELECT * FROM `jogadas` jo
                    INNER JOIN partidas pa ON pa.idPartida = jo.id_partida
                    WHERE jo.id_partida = {$_POST['idPartida']} 
                    ";
        
        $pre = $conexao->prepare($comando);
        $pre->execute(); 
       $dados  = Array();

        while ( $ln = $pre->fetch(PDO::FETCH_ASSOC))
        {
            //Verifica o icone
            if($ln['jogadorCasa'] === $ln['id_usuario'])
            {
                $icone = "X";
            }
            else
            {
                $icone = "O";
            }
            array_push($dados, ['icone' => $icone, 'posicao' => $ln['posicao'], 'vencedor' => $vencedor]);

           
        }

         
                          

        //Resposta
        echo json_encode($dados, JSON_PRETTY_PRINT);
        
    }