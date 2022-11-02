<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-09">
                <?php
                    //Dados da patida
                    include "conexao.php";
                   
                    
                    $comando = "SELECT jo.usuario jogadorVisitante, pa.idPartida idPartida FROM `partidas` as pa INNER JOIN jogadores as jo ON jo.idJogador = pa.jogadorVisitante WHERE pa.idPartida = {$_GET['id']};";
                    
        
                    $pre = $conexao->prepare($comando);
                    $pre->execute();

                    $ln = $pre->fetch(PDO::FETCH_ASSOC);
                    
                    
                ?>
                <h1>Partida: <?php echo $_SESSION['usuario']; ?> VS  <?php echo $ln['jogadorVisitante']; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-09">
                <table  class="tabuleiro">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    
        <div class="row">
            <div class="col-9">
                <form action="registrarJogada.php" method="POST">
                    <div >
                        <label for="linha">Linha: </label>
                        <input type="text" id="linha" name="linha" required>
                    </div>
                    <div >
                        <label for="coluna">Coluna: </label>
                        <input type="text" id="coluna" name="coluna" required>
                    </div>
                    <div>
                        <input type="hidden" name="idJogador" value="<?php echo $_SESSION['idUsuario']; ?>">
                        <input type="hidden" name="idPartida" value="<?php echo $_SESSION['idPartida'];?>">
                        <input type="submit" value="JOGAR">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>