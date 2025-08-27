<?php
include('sla.php'); // não para em erro
require('config.php'); // impede a execução em erro
require_once('header.php'); // puxa só uma vez

echo 'Conteúdo do site...';
echo "Nome do usuário: ".$usuario;