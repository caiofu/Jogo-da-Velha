<?php
    include "conexao.php";
    session_start();
 
    if($_POST['idPartida'] != NULL && $_POST['idAdversario'] != NULL)
    {
        $comando = "SELECT turno FROM partidas WHERE idPartida = {$_POST['idPartida']}";
        
        $pre = $conexao->prepare($comando);
        $pre->execute(); 

        $ln = $pre->fetch(PDO::FETCH_ASSOC);
    
        //VERIFICAR SE PLAYER GANHOU
        $posicoesVitoriosas = [
            [1,2,3],
            [4,5,6],
            [7,8,9],
            [1,5,9],//Diagonal
            [7,5,3],//Diagonal
            [1,4,7],
            [2,5,8],
            [3,6,9],
            ];
            
        $verifica = $conexao->prepare("SELECT * FROM jogadas jo INNER JOIN partidas pa ON jo.id_partida = pa.idPartida WHERE id_partida = {$_POST['idPartida']} ");
        $verifica->execute();
        $jogadasUsuario =[];
        $jogadasAdversario = [];
        $vencedor= 0;
        $empate = 0;

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

        //VERIFICA ANTES O EMPATE
        $tamanho = count($jogadasAdversario) + count($jogadasUsuario);

        if($tamanho < 9 )
        {
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
        }
        else //Empate
        {
            $empate = 1;
           
            $partida= $conexao->prepare("UPDATE partidas SET empate =1, statusPartida = 0  WHERE idPartida = {$_POST['idPartida']}");
            $partida->execute();

            $sqlEmpate = $conexao->prepare("UPDATE jogadores SET empate = empate +1 WHERE idJogador in ( {$_SESSION['idUsuario']}, {$_POST['idAdversario']} ) ");
            $sqlEmpate->execute();
        }

        //SQL PARA O VENCENDOR
        if($vencedor != 0)
        {
         
            $partida= $conexao->prepare("UPDATE partidas SET idUsuarioVitoria = $vencedor, statusPartida = 0 WHERE idPartida = {$_POST['idPartida']}");
            $partida->execute();
            
            $sqlVencedor = $conexao->prepare("UPDATE jogadores SET vitoria = vitoria +1 WHERE idJogador = {$vencedor}");
            $sqlVencedor->execute();
        }

        //SETA PARTIDA COMO CONCLUIDA
        
        //FIM DA VERIFICAÇAO DE VENCEDOR 
        //INSERT INTO jogadas (id_partida, posicao, id_usuario) VALUES ({$_POST['idPartida']}, {$_POST['posicao']}, {$_POST['idUsuario']})";
        
        $dados = ["turno" =>$ln['turno'], "vencedor" => $vencedor, "empate" => $empate];
         //Resposta
         echo json_encode($dados, JSON_PRETTY_PRINT);
       
    }