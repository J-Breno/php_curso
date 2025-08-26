<?php
function somar( int $n1, int $n2, &$total): int {
    $total = $n1 + $n2;
}

$x = 3;
$y = 2;
$soma = 0;
somar($x, $y, $soma);

echo "TOTAL: ".$soma;