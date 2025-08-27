<?php
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$idade = filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT);

if($nome && $email && $idade) {
    echo 'Nome: '.$nome."<br />";
    echo 'Email: '.$email."<br />";
    echo 'Idade: '.$idade;
} else {
    header('Location: index.php');
    exit;
}
