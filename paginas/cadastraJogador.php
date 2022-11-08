<?php
    include "conexao.php";
    session_start();

    if($_POST['usuario'] != NULL && $_POST['senha'] != NULL)
    {
        //VERIFICA SE ESSE USUARIO JA FOI CADASTRADO
        $ver  = $conexao->prepare("SELECT * FROM jogadores WHERE usuario = '{$_POST['usuario']}'");
        $ver->execute();
        
        if($ver->rowCount() == 0)// 0 - QUER DIZER QUE NÃO EXISTE ESSE USUARIO CADASTRADO AINDA
        {
            $senha =  password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $comando = "INSERT INTO `jogadores` (`usuario`, `senha`) VALUES ('{$_POST['usuario']}', '{$senha}')";
        
            $pre = $conexao->prepare($comando);

            if( $pre->execute() == 1)
            {
                //LOGA O USUARIO APOS O CADASTRO
                $us  = $conexao->prepare("SELECT * FROM jogadores WHERE usuario = '{$_POST['usuario']}'");
                $us->execute();
                $ln = $us->fetch(PDO::FETCH_ASSOC);

                $_SESSION['usuario'] = $ln['usuario'];
                $_SESSION['idUsuario']     = $ln['idJogador'];
                $_SESSION['logado'] = true;
                header('location: lobby.php');
            }
            else
            {
               
                //MENSAGEM DE ERRO
                $_SESSION['mensagem'] = "ERRO AO CADASTRAR !";
                header('location: ..\index.php');
            }
   
        }
        else
        {
             //MENSAGEM DE USUARIO JA CADASTRADO
             $_SESSION['mensagem'] = "ESSE USUÁRIO JA EXISTE !";
             header('location: ..\index.php');
        }
         
    }
