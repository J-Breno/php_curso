<?php
$nomeSujo = '   Breno   ';
$nomeLimpo = trim($nomeSujo);

echo "NOME SUJO: ".strlen($nomeSujo)."<br/>";
echo "NOME LIMPO: ".strlen($nomeLimpo);

$nome = "Breno";
echo strtolower($nome);
echo strtoupper($nome);

$nomeAlterado = str_replace("Breno", "João", $nome);
echo $nomeAlterado;

$nomeCompleto = "João Breno";

$nome2 = substr($nomeCompleto, 3, 3);
echo $nome2;