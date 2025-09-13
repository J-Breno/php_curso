<?php

use dao\PostDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/PostDaoMysql.php');

// Log inicial
error_log("=== AJAX_POST.PHP CALLED ===");
error_log("POST data: " . print_r($_POST, true));

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$txt = filter_input(INPUT_POST, 'txt', FILTER_SANITIZE_SPECIAL_CHARS);

$array = ['error' => ''];

error_log("Texto recebido: " . ($txt ? $txt : 'VAZIO'));

if ($txt) {
    try {
        $postDao = new PostDaoMysql($pdo);

        $newPost = new models\Post();
        $newPost->publicId = $postDao->generateUuid();
        $newPost->idUser = $userInfo->publicId;
        $newPost->type = 'text';
        $newPost->createdAt = gmdate('Y-m-d H:i:s');
        $newPost->body = $txt;

        error_log("Novo post object: " . print_r($newPost, true));
        error_log("User publicId: " . $userInfo->publicId);

        $success = $postDao->insert($newPost);

        if ($success) {
            error_log("Post inserido com sucesso: " . $newPost->publicId);
            $array['success'] = true;
            $array['message'] = 'Post criado com sucesso';
        } else {
            error_log("Falha ao inserir post no banco");
            $array['error'] = 'Erro ao inserir post no banco de dados';
        }
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        error_log("Trace: " . $e->getTraceAsString());
        $array['error'] = 'Erro: ' . $e->getMessage();
    }
} else {
    error_log("Texto do post vazio");
    $array['error'] = 'Texto do post não pode estar vazio';
}

error_log("Retornando: " . print_r($array, true));
header("Content-Type: application/json");
echo json_encode($array);
exit;