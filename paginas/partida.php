<?php 
    session_start();
    include "conexao.php";
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>partidas</title>
    <link rel="stylesheet" href="../css/index.css">
    <!-- CSS BOOSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
<div class="container">
        <div class="row justify-content-md-center">
            <div class="col-9">
                <h6>Ola <?php echo $_SESSION['usuario'];?></h6>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <!-- MENU -->
           
            <div class="col-12" style="border: 1px solid green; border-radius: 20px;" >
            <form action="cadastrarPartida.php" method="POST">
               <div class="row justify-content-md-center" >
                    <div class="col-md-6 mb-4">
                        <label for="jogadorCasa">Jogador da Casa</label>
                        <input type="text" class="form-control" id="jogadorCasa" name="jogadorCasa" value="<?php echo $_SESSION['usuario'];  ?>" required readonly>
                    </div>

               </div>
                    
               
                <div class="col-md-12" style="text-align:center;">X</div>
                <div class="row justify-content-md-center" >
                    <div class="col-md-6 mb-4">
                        <label for="jogadorVisitante">Jogador Visitante</label>
                        <select name="jogadorVisitante" id="jogadorVisitante" class="form-control">
                            <option value="" disabled selected >Selecione um oponente</option>
                            <?php
                                $comando = "SELECT * FROM jogadores WHERE idJogador <> {$_SESSION['idUsuario']}";
        
                                $pre = $conexao->prepare($comando);
                                $pre->execute();

                                while ($res= $pre->fetch(PDO::FETCH_ASSOC)) 
                                {
                                   echo "<option value='{$res['idJogador']}'>{$res['usuario']}</option>";
                                }
                            ?>
                        </select>
                        
                    </div>

               </div>

               <div class="row justify-content-md-center espaco-row" >
                <div class="col-md-6">
                      <input type="submit" class="form-control btn btn-success" value="CRIAR PARTIDA">          
                </div>
               </div>
              
                   
              
               </form>
            </div>
        </div>
</div>
<!-- JS BOOSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>