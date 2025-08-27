<?php
$array = [
    'nome' => 'Breno',
    'idade' => 19,
    'empresa' => 'B7Web',
    'cor' => 'azul',
    'profissao' => 'Fazedor de café'
];

$chaves =  array_keys($array);

print_r($chaves);

$values = array_values($array);

print_r($values);