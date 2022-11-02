<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Partidas</title>
     <!-- CSS BOOSTRAP -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center" style="align-items: center;">
            <div class="col-6" style="border: 1px solid green; border-radius: 20px; margin-top: 20%; padding: 30px; text-align: center;">
                <h1>Patidas criadas por <?php echo  $_SESSION['usuario']; ?></h1>
                <hr>
                <br>
                <?php
                    include "conexao.php";
                   
                    
                    $comando = "SELECT jo.usuario jogadorVisitante, pa.idPartida idPartida FROM `partidas` as pa INNER JOIN jogadores as jo ON jo.idJogador = pa.jogadorVisitante WHERE pa.jogadorCasa = {$_SESSION['idUsuario']};";
                    
        
                    $pre = $conexao->prepare($comando);
                    $pre->execute();

                    while ($ln = $pre->fetch(PDO::FETCH_ASSOC)) 
                    {
                       echo $_SESSION['usuario']. " X ".$ln['jogadorVisitante'].' ( ID:  '.$ln['idPartida'].') <a href="jogo_v1.php?id='.$ln['idPartida'].'"> Ir para partida</a> <hr>';
                    }
                    
                ?>
                
            </div>
        </div>
    </div>
</body>
</html>