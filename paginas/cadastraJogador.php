<?php
    include "conexao.php";

    if($_POST['usuario'] != NULL && $_POST['senha'] != NULL)
    {
        $senha =  password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $comando = "INSERT INTO `jogadores` (`usuario`, `senha`) VALUES ('{$_POST['usuario']}', '{$senha}')";
    
        $pre = $conexao->prepare($comando);
        $pre->execute();
       
        if($res)
        {

            session_start();
            
            $_SESSION['jogador'] = $_POST['usuario'] ;
            $_SESSION['idUsuario'] = $conexao->lastInsertId();

        }
    }
