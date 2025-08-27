<?php
$array = [
    'nome' => 'Breno',
    'idade' => 19,
    'empresa' => 'B7Web',
    'cor' => 'azul',
    'profissao' => 'Fazedor de café'
];

if(key_exists('idade', $array)) {
    $idade = $array['idade'];
    echo $idade.' anos';
} else {
    echo 'Não tem idade.';
}