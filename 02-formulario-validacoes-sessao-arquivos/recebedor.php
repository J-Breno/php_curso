<?php
$nome = filter_input(INPUT_POST, 'nome');
$idade = filter_input(INPUT_POST, 'idade');

if($nome && $idade) {
    echo 'Nome: '.$nome."<br />";
    echo 'Idade: '.$idade;
} else {
    header('Location: index.php');
    exit;
}
