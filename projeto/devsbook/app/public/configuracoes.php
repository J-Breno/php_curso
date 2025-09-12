<?php

use dao\UserDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/UserDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'config';
$pageTitle = 'Configurações';

$userDao = new UserDaoMysql($pdo);

require_once('../partials/header.php');
?>

    <section class="feed mt-10">
        <div class="card-light dark:card-dark rounded-2xl p-6 animate-fade-in">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 flex items-center justify-center mr-4 floating-element">
                    <i class="fas fa-cog text-primary-600 dark:text-primary-400 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-black">Configurações</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-600">Gerencie suas preferências e informações pessoais</p>
                </div>
            </div>

            <?php if (empty($_SESSION['flash']) === false) : ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-start dark:bg-red-900/20 dark:border-red-800/30 dark:text-red-300 animate-fade-in">
                    <i class="fas fa-check-circle mt-1 mr-3"></i>
                    <div>
                        <?= $_SESSION['flash'] ?>
                        <?php $_SESSION['flash'] = '' ?>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="configuracoes_action.php" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="gradient-border">
                        <div class="bg-white dark:bg-dark-800 rounded-xl p-1">
                            <label for="avatar" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600 px-3 pt-3">
                                Novo Avatar
                            </label>
                            <div class="flex items-center space-x-4 p-3">
                                <label for="avatar" class="cursor-pointer group">
                                    <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 group-hover:border-primary-500 dark:group-hover:border-primary-500 transition-colors duration-200 flex items-center justify-center relative">
                                        <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                                        <?php if ($userInfo->avatar && file_exists('../media/avatars/'.$userInfo->avatar)): ?>
                                            <img src="<?= $base ?>/media/avatars/<?= $userInfo->avatar ?>" alt="Avatar" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-full">
                                                <i class="fas fa-camera text-white text-xl"></i>
                                            </div>
                                        <?php else: ?>
                                            <i class="fas fa-camera text-gray-400 dark:text-gray-400 group-hover:text-primary-500 text-2xl"></i>
                                        <?php endif; ?>
                                    </div>
                                </label>
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    Clique para alterar<br>Máx. 2MB
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gradient-border">
                        <div class="bg-white dark:bg-dark-800 rounded-xl p-1">
                            <label for="cover" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600 px-3 pt-3">
                                Nova Capa
                            </label>
                            <div class="flex items-center space-x-4 p-3">
                                <label for="cover" class="cursor-pointer group">
                                    <div class="w-24 h-16 rounded-lg overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 group-hover:border-primary-500 dark:group-hover:border-primary-500 transition-colors duration-200 flex items-center justify-center relative">
                                        <input type="file" name="cover" id="cover" class="hidden" accept="image/*">
                                        <?php if ($userInfo->cover && file_exists('../media/covers/'.$userInfo->cover)): ?>
                                            <img src="<?= $base ?>/media/covers/<?= $userInfo->cover ?>" alt="Capa" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                <i class="fas fa-image text-white"></i>
                                            </div>
                                        <?php else: ?>
                                            <i class="fas fa-image text-gray-400 dark:text-gray-400 group-hover:text-primary-500"></i>
                                        <?php endif; ?>
                                    </div>
                                </label>
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    Clique para alterar<br>Máx. 5MB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-dark mb-4 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-primary-500"></i>
                        Informações Pessoais
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                Nome Completo *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="<?= htmlspecialchars($userInfo->name) ?>"
                                        minlength="2"
                                        maxlength="50"
                                        required
                                        class="input-light dark:input-dark w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                E-mail *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="<?= htmlspecialchars($userInfo->email) ?>"
                                        maxlength="64"
                                        required
                                        class="input-light dark:input-dark w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="birthdate" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                Data de Nascimento *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="text"
                                        name="birthdate"
                                        id="birthdate"
                                        value="<?= date("d/m/Y", strtotime($userInfo->birthdate)) ?>"
                                        required
                                        class="input-light dark:input-dark w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                Cidade
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-city text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="text"
                                        name="city"
                                        id="city"
                                        value="<?= htmlspecialchars($userInfo->city) ?>"
                                        maxlength="50"
                                        class="input-light dark:input-dark w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="work" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                Trabalho
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-briefcase text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="text"
                                        name="work"
                                        id="work"
                                        value="<?= htmlspecialchars($userInfo->work) ?>"
                                        maxlength="50"
                                        class="input-light dark:input-dark w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-dark mb-4 flex items-center">
                        <i class="fas fa-lock mr-2 text-primary-500"></i>
                        Alterar Senha
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-800 mb-4">Deixe em branco se não quiser alterar a senha</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="last-password" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                Senha Antiga
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="password"
                                        name="last-password"
                                        id="last-password"
                                        class="input-light dark:input-dark w-full pl-10 pr-10 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                Nova Senha
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="input-light dark:input-dark w-full pl-10 pr-10 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password-confirmation" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-600">
                                Confirmar Nova Senha
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400 dark:text-gray-400"></i>
                                </div>
                                <input
                                        type="password"
                                        name="password-confirmation"
                                        id="password-confirmation"
                                        class="input-light dark:input-dark w-full pl-10 pr-10 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 dark:placeholder-gray-500"
                                >
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 flex justify-between items-center">
                    <p class="text-sm text-gray-500 dark:text-gray-800">* Campos obrigatórios</p>
                    <button type="submit" class="btn-primary text-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-dark-800 transform transition-transform duration-200 hover:scale-105">
                        <i class="fas fa-save mr-2"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        // Máscara para data de nascimento
        const birthdateInput = document.getElementById('birthdate');
        const birthdateMask = IMask(birthdateInput, {
            mask: '00/00/0000',
            pattern: 'd`/m`/Y',
            blocks: {
                d: {
                    mask: IMask.MaskedRange,
                    from: 1,
                    to: 31,
                    maxLength: 2
                },
                m: {
                    mask: IMask.MaskedRange,
                    from: 1,
                    to: 12,
                    maxLength: 2
                },
                Y: {
                    mask: IMask.MaskedRange,
                    from: 1900,
                    to: new Date().getFullYear(),
                    maxLength: 4
                }
            },
            format: function (value) {
                if (value.length === 8) {
                    return value.replace(/(\d{2})(\d{2})(\d{4})/, '$1/$2/$3');
                }
                return value;
            },
            parse: function (value) {
                return value.replace(/\D/g, '');
            }
        });

        // Preview de imagem ao selecionar
        const avatarInput = document.getElementById('avatar');
        const coverInput = document.getElementById('cover');

        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = avatarInput.parentElement.querySelector('img') || document.createElement('img');
                        if (!avatarInput.parentElement.querySelector('img')) {
                            preview.className = 'w-full h-full object-cover';
                            avatarInput.parentElement.innerHTML = '';
                            avatarInput.parentElement.appendChild(preview);
                        }
                        preview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (coverInput) {
            coverInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = coverInput.parentElement.querySelector('img') || document.createElement('img');
                        if (!coverInput.parentElement.querySelector('img')) {
                            preview.className = 'w-full h-full object-cover';
                            coverInput.parentElement.innerHTML = '';
                            coverInput.parentElement.appendChild(preview);
                        }
                        preview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Validação do formulário
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password-confirmation').value;

            if (password !== passwordConfirmation) {
                event.preventDefault();
                // Mostrar mensagem de erro bonita
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-start dark:bg-red-900/20 dark:border-red-800/30 dark:text-red-300 animate-fade-in';
                errorDiv.innerHTML = `
                    <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                    <div>As senhas não coincidem!</div>
                `;
                form.prepend(errorDiv);

                // Scroll para o topo
                window.scrollTo({ top: 0, behavior: 'smooth' });

                // Remover a mensagem após 5 segundos
                setTimeout(() => {
                    errorDiv.remove();
                }, 5000);

                return false;
            }
        });

        // Melhorias visuais para o tema escuro
        document.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('focus', function() {
                this.classList.add('ring-2', 'ring-primary-500');
            });

            element.addEventListener('blur', function() {
                this.classList.remove('ring-2', 'ring-primary-500');
            });
        });
    </script>

<?php require_once('../partials/footer.php'); ?>