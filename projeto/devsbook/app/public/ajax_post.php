    <?php

    use dao\PostDaoMysql;
    use models\Auth;

    require_once('../config.php');
    require_once('../models/Auth.php');
    require_once('../dao/PostDaoMysql.php');

    $auth = new Auth($pdo, $base);
    $userInfo = $auth->checkToken();

    $txt = filter_input(INPUT_POST, 'txt', FILTER_SANITIZE_SPECIAL_CHARS);

    $array = [];

    if ($txt) {
        $postDao = new PostDaoMysql($pdo);

        $newPost = new models\Post();
        $newPost->publicId = $postDao->generateUuid();
        $newPost->idUser = $userInfo->publicId;
        $newPost->type = 'text';
        $newPost->createdAt = gmdate('Y-m-d H:i:s');
        $newPost->body = $txt;

        $postDao->insert($newPost);

        $array = [
            'error' => '',
        ];
    }

    header("Content-Type: application/json");
    echo json_encode($array);
    exit;