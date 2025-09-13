<?php

use dao\PostLikeDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/PostLikeDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

$array = ['error' => '', 'likeCount' => 0];

if ($id) {
    $postLikeDao = new PostLikeDaoMysql($pdo);
    $likeCount = $postLikeDao->getLikeCount($id);

    $array['likeCount'] = $likeCount;
}

header("Content-Type: application/json");
echo json_encode($array);
exit;