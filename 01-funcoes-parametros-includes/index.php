<?php
function somar( $n1, $n2 ) {
    return $n1 + $n2;
}

$x = somar(1, 3);
$y = somar(5, 3);
$soma = somar($x, $y);
echo "TOTAL: ".$soma;