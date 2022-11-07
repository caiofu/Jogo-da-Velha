<?php
    include "conexao.php";
 
    if($_POST['idPartida'] != NULL && $_POST['idUsuario'] != NULL && $_POST['idAdversario'] != NULL)
    {
        

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
            array_push($dados, ['icone' => $icone, 'posicao' => $ln['posicao']]);

           
        }

         
                          

        //Resposta
        echo json_encode($dados, JSON_PRETTY_PRINT);
        
    }