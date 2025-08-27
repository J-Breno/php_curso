<?php
$texto = file_get_contents('texto.php');
//file_put_contents('nome.txt', $texto);
$texto .= '\nJoão Breno';
file_put_contents('texto.php', $texto);

echo 'Arquivo criado com sucesso';