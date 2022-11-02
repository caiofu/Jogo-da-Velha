<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida</title>
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/teste.js"></script>
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
                <!--<table  class="tabuleiro">
                    <tr>
                        <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                        <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                        <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                        
                    </tr>
                    <tr>
                    <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                        <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                        <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                    </tr>
                    <tr>
                    <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                        <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                        <td>
                            <input type="radio" id="opcao" class="opcao">
                            <label for="opcao" class="testel"><img src="../img/qudarado.jpg" alt=""></label>
                        </td>
                    </tr>
                </table> -->

                <div class="tabuleiro2">
           
                            <label for="opcao1" class="box-selecao"><span id="sp1"></span><input type="radio" id="opcao1" class="opcao" name="opcao" value="1" onclick="teste();"></label>
                            <label for="opcao2" class="box-selecao"> <span id="sp2"></span><input type="radio" id="opcao2" class="opcao" name="opcao" value="2" onclick="teste();"></label>
                            <label for="opcao3" class="box-selecao"> <span id="sp3"></span><input type="radio" id="opcao3" class="opcao" name="opcao" value="3" onclick="teste();"></label>

                            <label for="opcao4" class="box-selecao"> <span id="sp4"></span><input type="radio" id="opcao4" class="opcao" name="opcao" value="4" onclick="teste();"></label>
                            <label for="opcao5" class="box-selecao"> <span id="sp5"></span> <input type="radio" id="opcao5" class="opcao" name="opcao" value="5" onclick="teste();"></label>
                            <label for="opcao6" class="box-selecao"> <span id="sp6"></span> <input type="radio" id="opcao6" class="opcao" name="opcao" value="6" onclick="teste();"></label>

                            <label for="opcao7" class="box-selecao"> <span id="sp7"></span> <input type="radio" id="opcao7" class="opcao" name="opcao" value="7" onclick="teste();"></label>
                            <label for="opcao8" class="box-selecao">  <span id="sp8"></span><input type="radio" id="opcao8" class="opcao" name="opcao" value="8" onclick="teste();"></label>
                            <label for="opcao9" class="box-selecao"> <span id="sp9"></span><span id="sp1"></span><input type="radio" id="opcao9" class="opcao" name="opcao" value="9" onclick="teste();"></label>

                            
                </div>
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
                        <input type="hidden" name="idPartida" value="<?php echo $_GET['id'];?>">
                        <input type="submit" value="JOGAR">
                    </div>
                </form>
            </div>
        </div>
<br><br>
<hr>
        <div class="row">
            <div class="col-9" style="background-color: green;">
                Voce nesssa partida é 
            </div>
        </div>
    </div>
</body>
</html>