<?php
    include "conexao.php";

    if($_POST['usuarioLogin'] != NULL && $_POST['senhaLogin'] != NULL)
    {
        $comando = "SELECT * FROM jogadores WHERE usuario = '{$_POST['usuarioLogin']}'";
        
        $pre = $conexao->prepare($comando);
        $pre->execute();

        $res= $pre->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST['senhaLogin'], $res['senha'] ) == true)
        {
            session_start();
            $_SESSION['usuario'] = $res['usuario'];
            $_SESSION['idUsuario']     = $res['idJogador'];
            header('location: partida.php');
        }
      
     
    }