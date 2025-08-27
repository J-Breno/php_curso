<?php
$nomeSujo = '   Breno   ';
$nomeLimpo = trim($nomeSujo);

echo "NOME SUJO: ".strlen($nomeSujo)."<br/>";
echo "NOME LIMPO: ".strlen($nomeLimpo);

$nome = "Breno";
echo ucfirst(strtolower($nome));
echo strtoupper($nome);

$nomeAlterado = str_replace("Breno", "João", $nome);
echo $nomeAlterado;

$nomeCompleto = "João Breno";

$nome2 = substr($nomeCompleto, 3, 3);
echo $nome2;

$posicao = strpos($nomeCompleto, 'a');
echo $posicao;

$nomes = explode(' ', $nomeCompleto);
print_r($nomes);

$numero = 12913.12;
echo number_format($numero, 2, ',', '.');