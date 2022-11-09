
<?php session_start(); include "paginas/verificaUsuario.php"; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo</title>
    <script src="js/index.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <!-- CSS BOOSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     <!-- SWEET ALERT CSS -->
     <link rel="stylesheet" href="css/sweetalert2.min.css">
</head>
<body>
    <div class="container">
       
        
       
           <!--  CADASTRAR USUARIO -->
            <div class="row justify-content-md-center" id="cadastraJogador">
            <div class="col-md-6 col-sm-12 box-cadastro" >
                <div style="text-align: center;" ><h1>Cadastrar</h1></div><hr>
                <form action="paginas/cadastraJogador.php" method="POST">
                    <div class="form-group">
                        <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nome do jogador" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
                    </div>
                       
                    <div class="form-group">
                        <input type="submit"  class="form-control btn btn-primary" value="Cadastrar">
                    </div>
                    <hr>
                            <div style="text-align: center;"><small >Já tem conta? <a href="#" id="btnAcao"  onclick="Menu('login')">Logar</a></small></div>
                        <hr>
                </form>
            </div>
        </div>

           <!--  LOGIN USUARIO -->
           <div class="row justify-content-md-center" id="loginJogador" style="display: none;">
            <div class="col-md-6 col-sm-12 box-login" style="">
            <div style="text-align: center;" ><h1>Logar</h1></div><hr>
                <form action="paginas/logaJogador.php" method="POST">
                    <div class="form-group">
                        <input type="text" id="usuarioLogin" name="usuarioLogin" class="form-control" placeholder="Nome do jogador" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="senhaLogin" name="senhaLogin" class="form-control" placeholder="Senha" required>
                    </div>
                       
                    <div class="form-group">
                        <input type="submit"  class="form-control btn btn-primary" value="Logar">
                    </div>
                    <hr>
                            <div style="text-align: center;"><small >Não tem uma conta? <a href="#" id="btnAcao" onclick="Menu('cadastro')">Cadastrar</a></small></div>
                        <hr>
                </form>
            </div>
        </div>
    </div>

    <!-- PASSANDO LETRAS PARA MAIUSCULA -->
    <script>
        //Usuario Cadastro
        document.getElementById('usuario').addEventListener('keyup', (ev) => 
        {
            const input = ev.target;
            input.value = input.value.toUpperCase();
        });

        //Usuario Login
        document.getElementById('usuarioLogin').addEventListener('keyup', (ev) => 
        {
            const input = ev.target;
            input.value = input.value.toUpperCase();
        });
    </script>
    <!-- JS SWEET ALERT -->
<script src="js/sweetalert2.js"></script>
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