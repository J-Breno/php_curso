<?php

use dao\PostDaoMysql;
use models\Auth;
use models\Post;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/PostDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$body = filter_input(INPUT_POST, 'body');

if ($body) {
    $postDao = new PostDaoMysql($pdo);

    $newPost = new Post();
    $newPost->idUser = $userInfo->publicId;  // Certifique-se de que está usando a chave correta para o usuário
    $newPost->type = 'text';  // Tipo de post (pode ser 'text' ou 'photo')
    $newPost->createdAt = gmdate('Y-m-d H:i:s');
    $newPost->body = $body;

    // Insira o novo post no banco de dados
    $postDao->insert($newPost);

    // Após a inserção, não redirecionar, mas retornar os dados para o front-end
    $response = [
        'error' => '',
        'post' => [
            'id' => $newPost->publicId,
            'body' => $newPost->body,
            'user' => $userInfo->name,
            'avatar' => $base . '/media/avatars/' . $userInfo->avatar,
            'createdAt' => $newPost->createdAt
        ]
    ];

    echo json_encode($response);
    exit;
}

// Caso contrário, redirecione de volta
header('Location: ' . $base);
exit;
?>
