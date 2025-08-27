<?php
session_start(); // Sessão funciona enquando o navegador estiver aberto
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$idade = filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT);

if($nome && $email && $idade) {

    $expiracao = time() + (86400 * 30);

    setcookie('nome', $nome, $expiracao ); // cookie fica salvo no computador, ele tem prazo de validade

    echo 'Nome: '.$nome."<br />";
    echo 'Email: '.$email."<br />";
    echo 'Idade: '.$idade;
} else {
    $_SESSION['aviso'] = 'Preencha os itens corretamentes';
    header('Location: index.php');
    exit;
}
