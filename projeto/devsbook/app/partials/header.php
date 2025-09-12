<?php $firstName = current(explode(' ', $userInfo->name)); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <title>DevsBook - <?= $pageTitle ?? 'Rede de Desenvolvedores' ?></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <meta name="theme-color" content="#ff2e2e">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff1f1',
                            100: '#ffdfdf',
                            200: '#ff6b6b',
                            300: '#ff4d4d',
                            400: '#ff2e2e',
                            500: '#e01e1e',
                            600: '#c81010',
                            700: '#a51010',
                            800: '#891515',
                            900: '#6a0f0f',
                        },
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        },
                        accent: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif']
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                        'glow': 'glow 3s ease-in-out infinite alternate',
                        'slide-in-right': 'slideInRight 0.5s ease-out',
                        'bounce-soft': 'bounceSoft 2s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        pulseSoft: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.02)' },
                        },
                        glow: {
                            '0%': { boxShadow: '0 0 20px rgba(255, 46, 46, 0.3)' },
                            '100%': { boxShadow: '0 0 30px rgba(255, 46, 46, 0.5), 0 0 40px rgba(255, 46, 46, 0.2)' },
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        bounceSoft: {
                            '0%, 20%, 53%, 80%, 100%': {
                                transform: 'translate3d(0,0,0)',
                                animationTimingFunction: 'cubic-bezier(0.215, 0.610, 0.355, 1.000)'
                            },
                            '40%, 43%': {
                                transform: 'translate3d(0, -5px, 0)',
                                animationTimingFunction: 'cubic-bezier(0.755, 0.050, 0.855, 0.060)'
                            },
                            '70%': {
                                transform: 'translate3d(0, -3px, 0)',
                                animationTimingFunction: 'cubic-bezier(0.755, 0.050, 0.855, 0.060)'
                            },
                            '90%': {
                                transform: 'translate3d(0, -1px, 0)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        :root {
            --primary-gradient: linear-gradient(135deg, #ff2e2e 0%, #e01e1e 100%);
            --primary-gradient-hover: linear-gradient(135deg, #e01e1e 0%, #c81010 100%);
            --dark-gradient: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            --dark-gradient-alt: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --light-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        body {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }

        .theme-light {
            background: var(--light-gradient);
            color: #0f172a;
        }

        .theme-dark {
            background: var(--dark-gradient-alt);
            color: #f8fafc;
        }

        .card-light {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
        }

        .card-dark {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow:
                    0 4px 20px rgba(0, 0, 0, 0.25),
                    0 0 0 1px rgba(255, 255, 255, 0.03);
            border-radius: 16px;
        }

        .input-light {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e2e8f0;
            color: #0f172a;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .input-light:focus {
            border-color: #ff2e2e;
            box-shadow: 0 0 0 3px rgba(255, 46, 46, 0.2);
        }

        .input-dark {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .input-dark:focus {
            border-color: #ff2e2e;
            box-shadow: 0 0 0 3px rgba(255, 46, 46, 0.25);
            background: rgba(15, 23, 42, 0.9);
        }

        .btn-primary {
            background: var(--primary-gradient);
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 46, 46, 0.3);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 46, 46, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .theme-switch {
            position: relative;
            display: inline-block;
            width: 62px;
            height: 34px;
        }

        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background: var(--primary-gradient);
        }

        input:checked + .slider:before {
            transform: translateX(28px);
        }

        .slider .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: white;
            transition: opacity 0.3s ease;
        }

        .slider .sun {
            left: 10px;
            opacity: 0;
        }

        .slider .moon {
            right: 10px;
            opacity: 1;
        }

        input:checked + .slider .sun {
            opacity: 1;
        }

        input:checked + .slider .moon {
            opacity: 0;
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        .logo-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-family: 'Space Grotesk', sans-serif;
        }

        .avatar-ring {
            border: 2px solid transparent;
            background: linear-gradient(#fff, #fff) padding-box,
            var(--primary-gradient) border-box;
        }

        .dark .avatar-ring {
            background: linear-gradient(#1e293b, #1e293b) padding-box,
            var(--primary-gradient) border-box;
        }

        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.5;
            filter: blur(50px);
            z-index: -1;
            animation: float 15s ease-in-out infinite;
        }

        .menu-item {
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .menu-item:hover {
            background: rgba(255, 46, 46, 0.1);
            transform: translateX(5px);
        }

        .menu-item.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 46, 46, 0.25);
        }

        .notification-dot {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #ff2e2e;
            border-radius: 50%;
            border: 2px solid;
        }

        .light .notification-dot {
            border-color: white;
        }

        .dark .notification-dot {
            border-color: #1e293b;
        }

        .gradient-border {
            position: relative;
            border-radius: 16px;
            background: linear-gradient(135deg, #ff2e2e, #e01e1e);
            padding: 1px;
        }

        .gradient-border > div {
            border-radius: 15px;
            overflow: hidden;
        }

        .dark .gradient-border {
            background: linear-gradient(135deg, #ff2e2e, #e01e1e, #c81010);
        }

        @media (max-width: 768px) {
            .decoration-circle {
                display: none;
            }
        }

        /* Animações suaves para transições de tema */
        .theme-transition * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>

<body class="font-sans theme-light min-h-screen flex flex-col theme-transition">
<!-- Elementos decorativos de fundo -->
<div class="decoration-circle w-80 h-80 bg-[#ff6b6b] top-0 -left-40"></div>
<div class="decoration-circle w-96 h-96 bg-[#6366f1] bottom-0 -right-40 animation-delay-2000"></div>
<div class="decoration-circle w-64 h-64 bg-[#06d6a0] top-1/2 left-1/3 animation-delay-4000"></div>

<header class="py-5 px-4 border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-dark-900/90 backdrop-blur-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <a href="<?= $base ?>" class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-lg glow">
                <i class="fas fa-code text-white text-xl"></i>
            </div>
            <span class="logo-text text-3xl">DevsBook</span>
        </a>

        <div class="flex items-center space-x-6">
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <form method="GET" action="<?= $base ?>/search.php">
                        <input
                                type="search"
                                placeholder="<?= isset($searchTerm) ? $searchTerm : 'Pesquisar...' ?>"
                                name="s"
                                class="input-light dark:input-dark pl-12 pr-4 py-3 rounded-2xl w-80 focus:outline-none focus:ring-2 focus:ring-primary-500"
                        />
                    </form>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <label class="theme-switch">
                    <input type="checkbox" id="theme-toggle">
                    <span class="slider">
                        <i class="fas fa-sun icon sun"></i>
                        <i class="fas fa-moon icon moon"></i>
                    </span>
                </label>

                <a href="<?= $base ?>/perfil.php" class="flex items-center space-x-3 p-2 rounded-2xl hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors duration-300">
                    <div class="w-12 h-12 rounded-full overflow-hidden avatar-ring">
                        <img src="<?= $base ?>/media/avatars/<?= $userInfo->avatar ?>?v=<?= $_SESSION['avatar_version'] ?? time() ?>" class="w-full h-full object-cover" id="header-avatar" />
                    </div>
                    <span class="text-gray-700 dark:text-gray-300 font-medium hidden md:block"><?= $firstName ?></span>
                </a>
            </div>
        </div>
    </div>
</header>

<div class="flex flex-1">
    <aside class="w-64 bg-white dark:bg-dark-800 border-r border-gray-200 dark:border-gray-800 hidden md:block">
        <nav class="p-4 space-y-2">
            <a href="<?= $base ?>" class="menu-item flex items-center space-x-3 p-3 <?= $activeMenu === 'home' ? 'active' : '' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                    <i class="fas fa-home text-lg"></i>
                </div>
                <span class="font-medium">Home</span>
            </a>
            <a href="<?= $base ?>/perfil.php" class="menu-item flex items-center space-x-3 p-3 <?= $activeMenu === 'profile' ? 'active' : '' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <span class="font-medium">Meu Perfil</span>
            </a>
            <a href="<?= $base ?>/amigos.php" class="menu-item flex items-center space-x-3 p-3 <?= $activeMenu === 'friends' ? 'active' : '' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <i class="fas fa-users text-lg"></i>
                </div>
                <span class="font-medium">Amigos</span>
            </a>
            <a href="<?= $base ?>/fotos.php" class="menu-item flex items-center space-x-3 p-3 <?= $activeMenu === 'photos' ? 'active' : '' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400">
                    <i class="fas fa-image text-lg"></i>
                </div>
                <span class="font-medium">Fotos</span>
            </a>
            <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
            <a href="<?= $base ?>/configuracoes.php" class="menu-item flex items-center space-x-3 p-3 <?= $activeMenu === 'config' ? 'active' : '' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                    <i class="fas fa-cog text-lg"></i>
                </div>
                <span class="font-medium">Configurações</span>
            </a>
            <a href="<?= $base ?>/logout.php" class="menu-item flex items-center space-x-3 p-3">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                    <i class="fas fa-power-off text-lg"></i>
                </div>
                <span class="font-medium">Sair</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-4 md:p-6">
        <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-dark-800 border-t border-gray-200 dark:border-gray-800 z-40">
            <nav class="flex justify-around py-2">
                <a href="<?= $base ?>" class="flex flex-col items-center p-2 rounded-lg <?= $activeMenu === 'home' ? 'text-primary-500 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400' ?>">
                    <i class="fas fa-home text-lg"></i>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="<?= $base ?>/perfil.php" class="flex flex-col items-center p-2 rounded-lg <?= $activeMenu === 'profile' ? 'text-primary-500 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400' ?>">
                    <i class="fas fa-user text-lg"></i>
                    <span class="text-xs mt-1">Perfil</span>
                </a>
                <a href="<?= $base ?>/amigos.php" class="flex flex-col items-center p-2 rounded-lg <?= $activeMenu === 'friends' ? 'text-primary-500 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400' ?>">
                    <i class="fas fa-users text-lg"></i>
                    <span class="text-xs mt-1">Amigos</span>
                </a>
                <a href="<?= $base ?>/fotos.php" class="flex flex-col items-center p-2 rounded-lg <?= $activeMenu === 'photos' ? 'text-primary-500 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400' ?>">
                    <i class="fas fa-image text-lg"></i>
                    <span class="text-xs mt-1">Fotos</span>
                </a>
                <a href="<?= $base ?>/configuracoes.php" class="flex flex-col items-center p-2 rounded-lg <?= $activeMenu === 'config' ? 'text-primary-500 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400' ?>">
                    <i class="fas fa-cog text-lg"></i>
                    <span class="text-xs mt-1">Config</span>
                </a>
            </nav>
        </div>