<?php
session_start();

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$_SESSION['nome'] = $nome;

if($_SESSION['nome']) {
    $nome = $_SESSION['nome'];
    echo 'Olá, '.$nome;
    $_SESSION['nome'] = '';
    echo " - <a href='exercicio1Login.php'>Sair</a>";
} else {
    header("Location: exercicio1Login.php");
    exit;
}
?>


