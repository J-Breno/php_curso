<?php
declare(strict_types=1);
session_start();

// Carrega funções utilitárias
require __DIR__ . '/core/functions.php';

// Carrega e executa rotas
require __DIR__ . '/config/routes.php';
