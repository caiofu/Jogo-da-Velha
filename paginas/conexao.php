<?php
 $usuarioBD = 'root';
 $senhaBD = '';
 $db = 'jogo';
 
 $conexao = new PDO("mysql:host=localhost;dbname={$db}", $usuarioBD, $senhaBD);