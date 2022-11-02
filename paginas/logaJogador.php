<?php
    include "conexao.php";
    session_start();
    if($_POST['usuarioLogin'] != NULL && $_POST['senhaLogin'] != NULL)
    {
        $comando = "SELECT * FROM jogadores WHERE usuario = '{$_POST['usuarioLogin']}'";
        
        $pre = $conexao->prepare($comando);
        $pre->execute();

        $res= $pre->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST['senhaLogin'], $res['senha'] ) == true)
        {
            
            $_SESSION['usuario'] = $res['usuario'];
            $_SESSION['idUsuario']     = $res['idJogador'];
            $_SESSION['logado'] = true;
            header('location: lobby.php');
        }
        else
        {
            $_SESSION['mensagem'] = "Senha errada!";
            header('location: ../index.php');
        }
      
     
    }