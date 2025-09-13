<?php

use dao\PostDaoMysql;
use dao\UserDaoMysql;
use dao\UserRelationDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/PostDaoMysql.php');
require_once('../dao/UserRelationDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'profile';

$publicId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$page = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT);

if ($publicId === $userInfo->publicId) {
    header("Location: $base/perfil.php");
    exit;
}

if ($publicId === null) {
    $publicId = $userInfo->publicId;
}

if ($publicId !== $userInfo->publicId) {
    $activeMenu = '';
}

if ($page === null || $page < 1) {
    $page = 1;
}

$postDao = new PostDaoMysql($pdo);
$userDao = new UserDaoMysql($pdo);
$userRelationDao = new UserRelationDaoMysql($pdo);

$user = $userDao->findById($publicId, true);

if (!$user) {
    header("Location: $base");
    exit;
}

$datefrom = new DateTime($user->birthdate);
$dateTo = new DateTime('today');

$user->ageYears = $datefrom->diff($dateTo)->y;

$info = $postDao->getUserFeed($publicId, $userInfo->publicId, $page);
$feed = $info['feed'];
$pages = $info['pages'];
$currentPage = $info['currentPage'];

$isFollowing = $userRelationDao->isFollowing($userInfo->publicId, $publicId);

require_once('../partials/header.php');
require_once('../partials/menu.php');
?>

    <section class="feed">
        <div class="mb-6">
            <div class="card-light dark:card-dark overflow-hidden">
                <!-- Cover Photo -->
                <div class="profile-cover h-48 bg-gradient-to-r from-primary-500 to-primary-600" style="background-image: url('<?= $base ?>/media/covers/<?= $user->cover ?>'); background-size: cover; background-position: center;">
                </div>

                <!-- Profile Info -->
                <div class="px-6 pb-6">
                    <div class="flex items-end -mt-16 mb-4">
                        <div class="profile-info-avatar w-32 h-32 rounded-full overflow-hidden border-4 border-white dark:border-dark-800 shadow-lg">
                            <img src="<?= $base ?>/media/avatars/<?= $user->avatar ?>" class="w-full h-full object-cover" />
                        </div>

                        <div class="ml-6 mb-4 flex-1">
                            <div class="profile-info-name-text text-2xl font-bold text-gray-900 dark:text-black">
                                <?= $user->name ?>
                            </div>
                            <?php if (empty($user->city) === false) : ?>
                                <div class="profile-info-location text-gray-600 dark:text-gray-400 flex items-center space-x-1 mt-1">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                    <span><?= $user->city ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Stats and Actions -->
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center space-x-6">
                            <?php if ($publicId !== $userInfo->publicId) : ?>
                                <a href="<?= $base ?>/follow_action.php?id=<?= $publicId ?>" class="btn-primary px-6 py-2 text-white rounded-xl font-medium transition-all duration-300 <?= $isFollowing ? 'bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600' : '' ?>">
                                    <?= $isFollowing ? 'Seguindo' : 'Seguir' ?>
                                    <?= $isFollowing ? '<i class="fas fa-check ml-2"></i>' : '<i class="fas fa-plus ml-2"></i>' ?>
                                </a>
                            <?php endif ?>

                            <div class="flex items-center space-x-6 text-center">
                                <div class="profile-info-item">
                                    <div class="profile-info-item-n text-2xl font-bold text-gray-900 dark:text-black"><?= count($user->followers) ?></div>
                                    <div class="profile-info-item-s text-sm text-gray-600 dark:text-gray-400">Seguidores</div>
                                </div>
                                <div class="profile-info-item">
                                    <div class="profile-info-item-n text-2xl font-bold text-gray-900 dark:text-black"><?= count($user->following) ?></div>
                                    <div class="profile-info-item-s text-sm text-gray-600 dark:text-gray-400">Seguindo</div>
                                </div>
                                <div class="profile-info-item">
                                    <div class="profile-info-item-n text-2xl font-bold text-gray-900 dark:text-black"><?= count($user->photos) ?></div>
                                    <div class="profile-info-item-s text-sm text-gray-600 dark:text-gray-400">Fotos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Info Box -->
                <div class="card-light dark:card-dark p-6">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-black mb-4">Informações</h3>

                    <div class="space-y-3">
                        <div class="user-info-mini flex items-center space-x-3 text-gray-700 ">
                            <div class="w-8 h-8 rounded-full bg-primary-100  flex items-center justify-center text-primary-600 ">
                                <i class="fas fa-calendar text-sm"></i>
                            </div>
                            <span><?= date('d/m/Y', strtotime($user->birthdate)) ?> (<?= $user->ageYears ?> anos)</span>
                        </div>

                        <?php if (empty($user->city) === false) : ?>
                            <div class="user-info-mini flex items-center space-x-3 text-gray-700 ">
                                <div class="w-8 h-8 rounded-full bg-blue-100  flex items-center justify-center text-blue-600 ">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </div>
                                <span><?= $user->city ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($user->work) === false) : ?>
                            <div class="user-info-mini flex items-center space-x-3 text-gray-700 ">
                                <div class="w-8 h-8 rounded-full bg-green-100  flex items-center justify-center text-green-600 ">
                                    <i class="fas fa-briefcase text-sm"></i>
                                </div>
                                <span><?= $user->work ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (count($user->following) > 0) : ?>
                    <div class="card-light dark:card-dark">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-lg text-gray-900 dark:text-black">
                                    Seguindo <span class="text-primary-600 dark:text-primary-400">(<?= count($user->following) ?>)</span>
                                </h3>
                                <a href="<?= $base ?>/amigos.php?id=<?= $user->publicId ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 text-sm font-medium">
                                    Ver todos
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-3 gap-4">
                                <?php foreach ($user->following as $item) : ?>
                                    <?php $friendFirstName = explode(' ', $item->name)[0]; ?>
                                    <a href="<?= $base ?>/perfil.php?id=<?= $item->publicId ?>" class="group text-center">
                                        <div class="friend-icon-avatar w-16 h-16 rounded-full overflow-hidden mx-auto mb-2 border-2 border-transparent group-hover:border-primary-500 transition-colors duration-200">
                                            <img src="<?= $base ?>/media/avatars/<?= $item->avatar ?>" class="w-full h-full object-cover" />
                                        </div>
                                        <div class="friend-icon-name text-sm text-gray-700  group-hover:text-primary-600 dark:group-hover:text-primary-400 truncate">
                                            <?= $friendFirstName ?>
                                        </div>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-6">
                <?php if (count($user->photos) > 0) : ?>
                    <div class="card-light dark:card-dark">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-lg text-gray-900 dark:text-black">
                                    Fotos <span class="text-primary-600 dark:text-primary-400">(<?= count($user->photos) ?>)</span>
                                </h3>
                                <a href="<?= $base ?>/fotos.php?id=<?= $publicId ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 text-sm font-medium">
                                    Ver todas
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php foreach ($user->photos as $key => $item) : ?>
                                    <?php if ($key < 4) : ?>
                                        <a href="#modal-<?= $key ?>" rel="modal:open" class="group">
                                            <div class="user-photo-item rounded-xl overflow-hidden shadow-md group-hover:shadow-xl transition-shadow duration-300">
                                                <img src="<?= $base ?>/media/uploads/<?= $item->body ?>" class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300" />
                                            </div>
                                        </a>
                                        <div id="modal-<?= $key ?>" style="display:none;">
                                            <div class="bg-white dark:bg-dark-800 p-6 rounded-2xl max-w-4xl mx-auto">
                                                <img src="<?= $base ?>/media/uploads/<?= $item->body ?>" class="w-full h-auto max-h-96 object-contain rounded-xl" />
                                                <div class="text-center mt-4">
                                                    <a href="#" rel="modal:close" class="btn-primary px-6 py-2 text-white rounded-xl">Fechar</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <?php if ($publicId === $userInfo->publicId) : ?>
                    <?php require('../partials/feed-editor.php') ?>
                <?php endif ?>

                <?php if (count($feed) > 0) : ?>
                    <div class="space-y-6">
                        <?php foreach ($feed as $item) : ?>
                            <?php require('../partials/feed-item.php') ?>
                        <?php endforeach ?>
                    </div>
                <?php else : ?>
                    <div class="card-light dark:card-dark p-12 text-center">
                        <i class="fas fa-newspaper text-4xl text-gray-400 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Nenhuma publicação ainda</h3>
                        <p class="text-gray-500 dark:text-gray-400">Quando <?= $user->name ?> publicar algo, aparecerá aqui.</p>
                    </div>
                <?php endif ?>

                <?php if ($pages > 1) : ?>
                    <div class="flex justify-center mt-8">
                        <div class="flex items-center space-x-2 bg-white dark:bg-dark-800 rounded-xl p-2 shadow-md">
                            <?php for ($q = 1; $q <= $pages; $q++) : ?>
                                <?php
                                $pageString = '';
                                if ($publicId === $userInfo->publicId) {
                                    $pageString = "$base/perfil";
                                    if ($q > 1) {
                                        $pageString .= "?p=$q";
                                    }
                                } else {
                                    $pageString = "$base/perfil?id=$publicId";
                                    if ($q > 1) {
                                        $pageString .= "&p=$q";
                                    }
                                }
                                ?>
                                <a href="<?= $pageString ?>" class="w-10 h-10 flex items-center justify-center rounded-xl font-medium transition-all duration-200 <?= $q == $currentPage ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-700' ?>">
                                    <?= $q ?>
                                </a>
                            <?php endfor ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>

    <script>
        // Script para os modais de foto (já existente)
        document.addEventListener('DOMContentLoaded', function() {
            const photoLinks = document.querySelectorAll('.user-photo-item a[rel="modal:open"]');
            // ... (resto do script existente)
        });
    </script>

<?php require_once('../partials/footer.php'); ?>