<?php 
    session_start();
    include "verificaUsuario.php"; 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida</title>
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/jogo.js"></script>
    <!-- SWEET ALERT CSS -->
    <link rel="stylesheet" href="../css/sweetalert2.min.css">

    
</head>
<body>
    <div >
       
            <div >
                <?php
                    //Dados da patida
                    include "conexao.php";
                   
                    
                    $comando = "SELECT pa.jogadorVisitante idJogadorVisitante, (SELECT usuario FROM jogadores  WHERE idJogador = pa.jogadorVisitante)  as jogadorVisitante, pa.jogadorCasa idJogadorCasa,  (SELECT usuario FROM jogadores  WHERE idJogador = pa.jogadorCasa)  as jogadorCasa, pa.nomePartida as nomePartida, pa.dataCriacao as dataCriacao, pa.idPartida as idPartida
                    FROM `partidas` as pa INNER JOIN jogadores as jo ON jo.idJogador = pa.jogadorVisitante WHERE pa.idPartida = {$_GET['id']};";
                    
        
                    $pre = $conexao->prepare($comando);
                    $pre->execute();

                    $ln = $pre->fetch(PDO::FETCH_ASSOC);
                    
                    
                ?>
                <h1>Partida: <?php echo $ln['jogadorCasa']; ?> VS  <?php echo $ln['jogadorVisitante']; ?></h1>
            </div>
        
            <?php

            //ATENÇAO TERA QUE CRIAR UMA FUNÇAO JS PARA FICAR VERIFICANDO.. NO INICIO DA PARTIDA QUANDO O USUARIO FOR OPNENTE PARA N TER PROBLEMAS 
            //OU VERIFICAR DIRETAMENTE DE QUEM É O TURNO..
                        //VERIFICA SE E O JOGADOR QUE CRIOU
                        $mensagem = ""; //Só para previnir erros
                        $idAdversario ="";
                        if($ln['idJogadorCasa'] == $_SESSION['idUsuario'])
                        {
                            $mensagem = "Voce nesssa partida é: X - (CASA)";
                            $iconeJogador = "X";
                            $idAdversario = $ln['idJogadorVisitante'];
                          
                        }
                        else
                        {
                            $mensagem =  "Voce nesssa partida é: O - (VISITANTE)";
                            $iconeJogador = "O";
                            $idAdversario = $ln['idJogadorCasa'];
                            
                        }
                   
                   ?> 
                <div class="tabuleiro2" id="tabuleiro2">
           
                            <label for="opcao1" class="box-selecao"><span id="sp1"></span><input type="radio" id="opcao1" class="opcao" name="opcao" value="1" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>
                            <label for="opcao2" class="box-selecao"> <span id="sp2"></span><input type="radio" id="opcao2" class="opcao" name="opcao" value="2" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>
                            <label for="opcao3" class="box-selecao"> <span id="sp3"></span><input type="radio" id="opcao3" class="opcao" name="opcao" value="3" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>

                            <label for="opcao4" class="box-selecao"> <span id="sp4"></span><input type="radio" id="opcao4" class="opcao" name="opcao" value="4" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>
                            <label for="opcao5" class="box-selecao"> <span id="sp5"></span> <input type="radio" id="opcao5" class="opcao" name="opcao" value="5" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>
                            <label for="opcao6" class="box-selecao"> <span id="sp6"></span> <input type="radio" id="opcao6" class="opcao" name="opcao" value="6" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>

                            <label for="opcao7" class="box-selecao"> <span id="sp7"></span> <input type="radio" id="opcao7" class="opcao" name="opcao" value="7" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>
                            <label for="opcao8" class="box-selecao">  <span id="sp8"></span><input type="radio" id="opcao8" class="opcao" name="opcao" value="8" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');;"></label>
                            <label for="opcao9" class="box-selecao"> <span id="sp9"></span><input type="radio" id="opcao9" class="opcao" name="opcao" value="9" onclick="posicaoEscolhida('<?php echo $iconeJogador;?>');"></label>

                            
                </div>
           
    
        <div class="row">
            <div class="col-9" style="text-align: center;">
                <form action="registrarJogada.php" method="POST">
                   
                    <div>
                        <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>">
                        <input type="hidden" name="idAdversario" id="idAdversario" value="<?php echo $idAdversario; ?>">
                        <input type="hidden" name="idPartida" id="idPartida" value="<?php echo $_GET['id'];?>">
                        <br><br>
                        <div id="aguardando"></div>
                        <br><br>
                        <div id="btnFinalizarTurno"></div>
                    </div>
                    <?php
                        //Ao entrar verifica o turno se é do jogador ou do adversario     
                        echo "<script> VerificaTurno();</script>" ?>
                </form>
            </div>
        </div>
<br><br>
<hr>
        <div class="row">
            <div class="col-9" style="background-color: green; color: white;">
            <?php
                echo $mensagem;
            ?>
                
            </div>
        </div>
    </div>
       <!-- JS SWEET ALERT -->
        <script src="../js/sweetalert2.js"></script>
</body>
</html>