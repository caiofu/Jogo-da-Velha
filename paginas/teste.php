<?php
include "conexao.php";
$veri  = $conexao->prepare("SELECT statusPartida FROM partidas WHERE idPartida = 19");
$veri->execute();
$ln = $veri->fetch(PDO::FETCH_ASSOC);
var_dump($ln);