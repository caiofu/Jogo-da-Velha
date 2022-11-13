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
    <title>Lobby</title>
    <script src="../js/jogo.js"></script>
    <link rel="stylesheet" href="../css/index.css">
    
    <!-- CSS BOOSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- ICONES -->
    <link rel="stylesheet" href="../css/icones.css">
    <!-- SWEET ALERT CSS -->
    <link rel="stylesheet" href="../css/sweetalert2.min.css">

      <!-- ANIMATE -->
      <link rel="stylesheet" href="../css/animate.min.css">

      <script src="https://kit.fontawesome.com/0ff3b9cf3b.js" crossorigin="anonymous"></script>
</head>
<body>
<style>
    .animate__animated.animate__shakeX {
        --animate-duration: 6s;
    }
    .fundo-gorgeta
    {
        text-align: center;
        border: 1px solid red;
        border-radius: 20px;
        padding: 20px;
        background-color: rgb(0 123 255 / 25%);
        box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
    }
</style>
<div class="container">
    <br>
    <div class="row justify-content-md-center ">
        <div class="col-md-6 col-sm-12 fundo-gorgeta" >
            <div class="animate__animated  animate__shakeX animate__infinite	infinite animate__delay-3s	3s">
                Deixe uma gorjeta para o desenvolvedor <i> <img src="../img/doacao.png" alt="" width="60"></i>
            </div>
            <br>
            <div style="font-size: 22px;">
                PIX: caiofuu@gmail.com
            </div>
        </div>
    </div>
    <br>
 
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
                        <select name="jogadorVisitante" id="jogadorVisitante" class="form-control" required>
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
                           
                            //Verifica se partida foi criada a 24 horas e exclui caso tenha sido criada
                            $verificaCriacao = $conexao->prepare("SELECT * FROM partidas WHERE  jogadorCasa = {$_SESSION['idUsuario']} OR jogadorVisitante = {$_SESSION['idUsuario']}");
                            $verificaCriacao->execute();
                            $dataAgora = new DateTime( date('Y-m-d H:i:s'));    
                            while($v = $verificaCriacao->fetch(PDO::FETCH_ASSOC))
                            {
                              
                              $dataCriacao  = new DateTime($v['dataCriacao']);
                           
                              $diferenca = $dataCriacao->diff($dataAgora);

                              if($diferenca >= 1)
                              {
                                  //Exclui partida e jogadas
                                  $delPartida  = $conexao->prepare("DELETE FROM partidas WHERE idPartida =  {$v['idPartida']} AND statusPartida = 1");
                                  $delJogadas = $conexao->prepare("DELETE FROM jogadas WHERE id_partida =  {$v['idPartida']}  AND statusPartida = 1");
          
                                  $delPartida->execute();
                                  $delJogadas->execute();
          
                               
                              }
                            }
                            
                            $comando = " SELECT pa.statusPartida, pa.jogadorVisitante idJogadorVisitante, (SELECT usuario FROM jogadores  WHERE idJogador = pa.jogadorVisitante)  as jogadorVisitante, pa.jogadorCasa idJogadorCasa,  (SELECT usuario FROM jogadores  WHERE idJogador = pa.jogadorCasa)  as jogadorCasa, pa.nomePartida as nomePartida, pa.dataCriacao as dataCriacao, pa.idPartida as idPartida
                            FROM `partidas` as pa INNER JOIN jogadores as jo ON jo.idJogador = pa.jogadorVisitante WHERE  pa.jogadorCasa = {$_SESSION['idUsuario']} OR pa.jogadorVisitante = {$_SESSION['idUsuario']} HAVING pa.statusPartida = 1";
                            
                
                            $pre = $conexao->prepare($comando);
                            $pre->execute();

                            while ($ln = $pre->fetch(PDO::FETCH_ASSOC)) 
                            {
                                //VERIFICA SE VOCE CRIOU A PARTIDA OU UM ADVERSARIO
                                if($ln['idJogadorCasa'] == $_SESSION['idUsuario']) //Jogador que criou é o usuario logado
                                {
                                    echo "Você criou: ". $ln['jogadorCasa']. " X ".$ln['jogadorVisitante'].'  <a href="jogo_v1.php?id='.$ln['idPartida'].'"> Ir para partida</a> <hr>';
                                }
                                else
                                {
                                    echo "<span style='color:red;'>Você foi desafiado por:</span>  ". $ln['jogadorCasa']. " X ".$ln['jogadorVisitante'].' <a href="jogo_v1.php?id='.$ln['idPartida'].'"> Ir para partida</a> <hr>';
                                }
                                 
                            }
                            if($pre->rowCount() == 0)
                            {
                              echo "Nenhuma partida até o momento!<br><hr>";
                            }
                            
                        ?> 
                    </div>    
               </div>
              
         
               <div class="row justify-content-center" style="align-items: center;">
                    <div class="col div-ranking" >
                            <a href="#" data-toggle="modal" data-target="#modalRanking"><i class="fa-solid fa-ranking-star fa-2xl"></i> <br>  Ver ranking</a>
                    </div>
                </div>
                  
               
              
               </form>
            </div>
        </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRanking" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div style="text-align: center; width: 100%;"><h5 class="modal-title" id="staticBackdropLabel">Ranking Global - Top 30</h5></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="msg-carregando-modal" style="display: none;"></div>
      <div class="modal-body" id="conteudo-modal">
        
      <table class="table table-dark table-responsive">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Vitórias</th>
            <th scope="col">Derrotas</th>
            <th scope="col">Empate</th>
          </tr>
        </thead>
        <tbody id="corpo-ranking">
          <?php 
              $comando = "SELECT * FROM jogadores WHERE vitoria > 0 ORDER BY vitoria DESC LIMIT 30";
              
              $pre = $conexao->prepare($comando);
              $pre->execute(); 
              $colocacao = 0;
           
              while ($ln = $pre->fetch(PDO::FETCH_ASSOC))
              {
                $colocacao++;
                if($ln['idJogador'] ==  $_SESSION['idUsuario'])
                {
                  $bgPosicao = "style='background-color: green;'";
                }
                else
                {
                  $bgPosicao = "";
                }
                  echo "<tr {$bgPosicao}>
                        
                          <td>{$colocacao}</td>
                          <td>{$ln['usuario']}</td>
                          <td>{$ln['vitoria']}</td>
                          <td>{$ln['derrota']}</td>
                          <td>{$ln['empate']}</td>
                        </tr>";
              }
          ?>
        </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="AtualizaRanking(<?php echo $_SESSION['idUsuario']; ?>)">Atualizar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- JS SWEET ALERT -->
<script src="../js/sweetalert2.js"></script>
<!-- JS BOOSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<?php
//VERIFICA SE EXITE MENSAGEM
if(@$_SESSION['mensagem'] != NULL)
{
    echo "<script> 
    Swal.fire({
      icon: 'error',
      title: 'Erro!',
      confirmButtonColor: '#007bff',
      text: '".$_SESSION['mensagem']."',
     
    }) </script>";

    $_SESSION['mensagem'] = NULL;
}
?>
</body>
</html>