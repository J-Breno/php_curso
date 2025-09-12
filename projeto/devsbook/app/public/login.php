<?php
require_once('../config.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <title>Login - DevsBook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
                            200: '#ffc5c5',
                            300: '#ff9d9d',
                            400: '#ff6464',
                            500: '#ff2e2e', // Vermelho mais vibrante
                            600: '#ed1c1c',
                            700: '#c81010',
                            800: '#a51010',
                            900: '#891515',
                        },
                        dark: {
                            50: '#4a4a4a',
                            100: '#3c3c3c',
                            200: '#323232',
                            300: '#2d2d2d',
                            400: '#222222',
                            500: '#1a1a1a', // Preto mais profundo
                            600: '#171717',
                            700: '#141414',
                            800: '#101010',
                            900: '#0a0a0a',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
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
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        :root {
            --primary-gradient: linear-gradient(135deg, #ff2e2e 0%, #c81010 100%);
            --dark-gradient: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
        }

        body {
            transition: all 0.3s ease;
            overflow-x: hidden; /* CORREÇÃO: Impede scroll horizontal */
        }

        .theme-light {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1a202c;
        }

        .theme-dark {
            background: var(--dark-gradient);
            color: #e2e8f0;
        }

        .card-light {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .card-dark {
            background: rgba(26, 26, 26, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .input-light {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid #e2e8f0;
            color: #1a202c;
            transition: all 0.3s ease;
        }

        .input-light:focus {
            border-color: #ff2e2e;
            box-shadow: 0 0 0 3px rgba(255, 46, 46, 0.15);
        }

        .input-dark {
            background: rgba(26, 26, 26, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
            transition: all 0.3s ease;
        }

        .input-dark:focus {
            border-color: #ff2e2e;
            box-shadow: 0 0 0 3px rgba(255, 46, 46, 0.2);
        }

        .btn-primary {
            background: var(--primary-gradient);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(255, 46, 46, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 46, 46, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .theme-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 32px;
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
            background: var(--dark-gradient);
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
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
        }

        .slider .sun {
            left: 8px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .slider .moon {
            right: 8px;
            opacity: 1;
            transition: opacity 0.3s ease;
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

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .logo-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.5;
            filter: blur(40px);
            z-index: -1;
        }

        /* CORREÇÃO: Media queries para os círculos decorativos */
        @media (max-width: 768px) {
            .decoration-circle {
                display: none; /* Esconde os círculos em dispositivos móveis */
            }
        }
    </style>
</head>

<body class="font-sans theme-light min-h-screen flex flex-col">
<!-- Elementos decorativos de fundo - CORREÇÃO: Ajustados para não causar overflow -->
<div class="decoration-circle w-64 h-64 bg-primary-400 top-0 -left-20 md:-left-32"></div>
<div class="decoration-circle w-72 h-72 bg-primary-500 bottom-0 -right-20 md:-right-32"></div>

<header class="py-5 px-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="<?= $base ?>" class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-lg bg-primary-500 flex items-center justify-center shadow-lg">
                <i class="fas fa-code text-white text-lg"></i>
            </div>
            <span class="logo-text text-3xl">DevsBook</span>
        </a>

        <label class="theme-switch">
            <input type="checkbox" id="theme-toggle">
            <span class="slider">
                    <i class="fas fa-sun icon sun"></i>
                    <i class="fas fa-moon icon moon"></i>
                </span>
        </label>
    </div>
</header>

<main class="flex-grow flex items-center justify-center px-4 py-8">
    <div class="card-light dark:card-dark rounded-2xl p-8 max-w-md w-full transition-all duration-300 animate-slide-up">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center mx-auto mb-4 floating-element">
                <i class="fas fa-lock text-primary-600 dark:text-primary-400 text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Acesse sua conta</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Entre para conectar com outros desenvolvedores</p>
        </div>

        <?php if (empty($_SESSION['flash']) === false) : ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-start dark:bg-red-900/20 dark:border-red-800/30 dark:text-red-300 animate-fade-in">
                <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                <div>
                    <?= $_SESSION['flash'] ?>
                    <?php $_SESSION['flash'] = '' ?>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= $base ?>/login_action.php" class="space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300" for="email">
                    E-mail
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input
                            id="email"
                            placeholder="seu@email.com"
                            class="input-light dark:input-dark w-full pl-10 pr-3 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500"
                            type="email"
                            name="email"
                            required
                    />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300" for="password">
                    Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input
                            id="password"
                            placeholder="Sua senha secreta"
                            class="input-light dark:input-dark w-full pl-10 pr-10 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500"
                            type="password"
                            name="password"
                            required
                    />
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" id="togglePassword">
                        <i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></i>
                    </button>
                </div>
            </div>

            <button
                    class="btn-primary text-white font-semibold py-3 px-4 rounded-xl w-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-dark-700"
                    type="submit"
            >
                <i class="fas fa-sign-in-alt mr-2"></i> Entrar na conta
            </button>

            <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Não tem uma conta?
                    <a
                            href="<?= $base ?>/signup.php"
                            class="text-primary-600 hover:text-primary-700 font-semibold dark:text-primary-400 dark:hover:text-primary-300 transition-colors duration-200"
                    >
                        Cadastre-se agora
                    </a>
                </p>
            </div>
        </form>
    </div>
</main>

<footer class="py-6 px-4 text-center">
    <p class="text-sm text-gray-600 dark:text-gray-400">
        © 2025 DevsBook - Conectando desenvolvedores ao redor do mundo
    </p>
</footer>

<script>
    // Função para alternar entre temas
    const toggle = document.getElementById('theme-toggle');
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

    // Verificar preferência do sistema ou tema salvo
    const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme.matches ? 'dark' : 'light');

    if (currentTheme === 'dark') {
        document.body.classList.remove('theme-light');
        document.body.classList.add('theme-dark');
        toggle.checked = true;
    } else {
        document.body.classList.remove('theme-dark');
        document.body.classList.add('theme-light');
        toggle.checked = false;
    }

    // Alternar tema quando o botão for clicado
    toggle.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.remove('theme-light');
            document.body.classList.add('theme-dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.body.classList.remove('theme-dark');
            document.body.classList.add('theme-light');
            localStorage.setItem('theme', 'light');
        }
    });

    // Mostrar/ocultar senha
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
</body>

</html>