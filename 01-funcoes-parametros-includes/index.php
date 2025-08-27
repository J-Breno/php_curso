<?php
$lista = ['nome1', 'nome2', 'nome3', 'nome4', 'nome5'];
$aprovados = ['nome1', 'nome2', 'nome3'];
$reprovados = array_diff($lista, $aprovados);

echo "Total;: ".count($lista);
print_r($reprovados);

$numeros = [10, 20, 30, 40, 50];
$filtrados = array_filter($numeros, function ($item) {
    if($item < 30) {
        return true;
    } else {
        return false;
    }
});

print_r($filtrados);
$dobrados = array_map(function ($item) {
    return $item * 2;
}, $numeros);
print_r($dobrados);

array_pop($numeros);
array_shift($numeros);

if(in_array(90, $numeros)) {
    return 'Existe';
} else {
    return 'Não existe.';
}

$pos = array_search($numeros);
echo sort($numeros);
echo rsort($numeros );
asort($numeros);

$nome3 = implode('@', $nmmmeros);''