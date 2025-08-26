<?php
function somar( int $n1, int $n2, int $n3 = 0 ): int {
    return $n1 + $n2 + $n3;
}

$x = somar(1, 3);
$y = somar(5, 3, 2);
$soma = somar($x, $y);
echo "TOTAL: ".$soma;