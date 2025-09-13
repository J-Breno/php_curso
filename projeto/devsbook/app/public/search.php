<?php

use dao\UserDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/UserDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = '';

$userDao = new UserDaoMysql($pdo);

$searchTerm = filter_input(INPUT_GET, 's', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($searchTerm)) {
    header("Location: $base");
    exit;
}

$userList = $userDao->findByName($searchTerm);

require_once('../partials/header.php');
require_once('../partials/menu.php');
?>

    <section class="feed mt-10">
        <div class="container mx-auto px-4">
            <!-- Cabeçalho da pesquisa -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                        Resultados da pesquisa
                    </h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold text-primary-600 dark:text-primary-400"><?= count($userList) ?></span>
                        resultado(s) encontrado(s)
                    </div>
                </div>

                <!-- Barra de pesquisa -->

            </div>

            <!-- Resultados -->
            <?php if (count($userList) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($userList as $userItem): ?>
                        <?php
                        $friendFirstName = explode(' ', $userItem->name)[0];
                        $isCurrentUser = $userItem->publicId === $userInfo->publicId;
                        ?>

                        <div class="card-light dark:card-dark p-6 transition-all duration-300 hover:shadow-lg">
                            <div class="text-center">
                                <!-- Avatar -->
                                <a href="<?= $base ?>/perfil.php?id=<?= $userItem->publicId ?>" class="block">
                                    <div class="w-20 h-20 rounded-full overflow-hidden mx-auto mb-4 border-4 border-white dark:border-dark-800 shadow-lg avatar-ring">
                                        <img src="<?= $base ?>/media/avatars/<?= $userItem->avatar ?>"
                                             class="w-full h-full object-cover"
                                             alt="<?= $userItem->name ?>" />
                                    </div>
                                </a>

                                <!-- Nome -->
                                <a href="<?= $base ?>/perfil.php?id=<?= $userItem->publicId ?>">
                                    <h3 class="font-semibold text-lg text-gray-900  mb-1 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                        <?= $userItem->name ?>
                                    </h3>
                                </a>

                                <!-- Cidade (se disponível) -->
                                <?php if (!empty($userItem->city)): ?>
                                    <div class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-xs mr-1"></i>
                                        <span><?= $userItem->city ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Botão de ação -->
                                <div class="mt-4">
                                    <?php if ($isCurrentUser): ?>
                                        <span class="inline-block bg-gray-100 dark:bg-dark-700 text-gray-600 dark:text-gray-400 px-4 py-2 rounded-xl text-sm">
                                        <i class="fas fa-user mr-1"></i> Você
                                    </span>
                                    <?php else: ?>
                                        <a href="<?= $base ?>/perfil.php?id=<?= $userItem->publicId ?>"
                                           class="inline-block bg-primary-500 hover:bg-primary-600 dark:bg-primary-600 dark:hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm transition-all duration-300 transform hover:scale-105">
                                            Ver perfil
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Estado vazio -->
                <div class="card-light dark:card-dark p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-dark-700 flex items-center justify-center">
                            <i class="fas fa-search text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nenhum resultado encontrado
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Não encontramos usuários correspondentes a "<?= htmlspecialchars($searchTerm) ?>". Tente outros termos de pesquisa.
                        </p>
                        <a href="<?= $base ?>/amigos.php"
                           class="btn-primary inline-flex items-center px-4 py-2 rounded-xl">
                            <i class="fas fa-users mr-2"></i> Ver todos os amigos
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer estilizado -->
    <div class="mt-12 mb-6">
        <div class="container mx-auto px-4">
            <div class="card-light dark:card-dark p-6 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Criado com ❤️ por
                    <a href="https://github.com/J-Breno" target="_blank" rel="noreferrer"
                       class="text-primary-600 dark:text-primary-400 hover:underline font-medium">
                        @jbreno.io
                    </a>
                </p>
            </div>
        </div>
    </div>

<?php require_once('../partials/footer.php'); ?>