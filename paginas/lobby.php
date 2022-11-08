<?php 
    session_start();
    include "verificaUsuario.php"; 
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
    <!-- SWEET ALERT CSS -->
    <link rel="stylesheet" href="../css/sweetalert2.min.css">

      <!-- ANIMATE -->
      <link rel="stylesheet" href="../css/animate.min.css">
</head>
<body>
<div class="container">
       
        <div class="row justify-content-md-center animate__animated animate__bounceInRight">
            <!-- MENU -->
           
            <div class="col-md-6 col-sm-12 box-inicial-partida" >
            <div class="row justify-content-md-center" >
                <div class="col titulo-box-cria-partida">
                <h5> <?php echo $_SESSION['usuario'];?>, bem vindo ao Jogo da Velha</h5>
                </div>
            </div>
            <hr>
            <form action="cadastrarPartida.php" method="POST">
               <div class="row justify-content-md-center" >
                    <div class="col-md-6 mb-4">
                        <label for="jogadorCasa">Jogador da Casa</label>
                        <input type="text" class="form-control" id="jogadorCasa" name="jogadorCasa" value="<?php echo $_SESSION['usuario'];  ?>" required readonly>
                    </div>

               </div>
                    
               
                <div class="col" style="text-align:center;">X</div>
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
                <div class="col">
                      <input type="submit" class="form-control btn btn-success" value="CRIAR PARTIDA">            
                </div>     
               </div>

               
               <div class="row justify-content-center" style="align-items: center;">
                    <div class="col" style="text-align: center;" >
                    <div class="separador">Partidas criadas </div>
                     
                       
                        <br>
                        <?php
                            include "conexao.php";
                        
                            
                            $comando = " SELECT pa.jogadorVisitante idJogadorVisitante, (SELECT usuario FROM jogadores  WHERE idJogador = pa.jogadorVisitante)  as jogadorVisitante, pa.jogadorCasa idJogadorCasa,  (SELECT usuario FROM jogadores  WHERE idJogador = pa.jogadorCasa)  as jogadorCasa, pa.nomePartida as nomePartida, pa.dataCriacao as dataCriacao, pa.idPartida as idPartida
                            FROM `partidas` as pa INNER JOIN jogadores as jo ON jo.idJogador = pa.jogadorVisitante WHERE pa.jogadorCasa = {$_SESSION['idUsuario']} OR pa.jogadorVisitante = {$_SESSION['idUsuario']} ";
                            
                
                            $pre = $conexao->prepare($comando);
                            $pre->execute();

                            while ($ln = $pre->fetch(PDO::FETCH_ASSOC)) 
                            {
                                //VERIFICA SE VOCE CRIOU A PARTIDA OU UM ADVERSARIO
                                if($ln['idJogadorCasa'] == $_SESSION['idUsuario']) //Jogador que criou é o usuario logado
                                {
                                    echo "Você criou: ". $ln['jogadorCasa']. " X ".$ln['jogadorVisitante'].' ( ID:  '.$ln['idPartida'].') <a href="jogo_v1.php?id='.$ln['idPartida'].'"> Ir para partida</a> <hr>';
                                }
                                else
                                {
                                    echo "<span style='color:red;'>Você foi desafiado por:</span>  ". $ln['jogadorCasa']. " X ".$ln['jogadorVisitante'].' ( ID:  '.$ln['idPartida'].') <a href="jogo_v1.php?id='.$ln['idPartida'].'"> Ir para partida</a> <hr>';
                                }
                                 
                            }
                            
                        ?> 
                    </div>    
               </div>
              
                   
              
               </form>
            </div>
        </div>
</div>
<!-- JS SWEET ALERT -->
<script src="../js/sweetalert2.js"></script>
<!-- JS BOOSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>