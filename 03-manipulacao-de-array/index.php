<?php
$numeros = [1, 2, 3, 4, 5];

function somar($subtotal, $item) {
    $subtotal += $item;
    return $subtotal;
}

$total = array_reduce($numeros, 'somar');