</main>
</div>

<footer class="py-6 px-4 text-center border-t border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-dark-900/80 backdrop-blur-md">
    <p class="text-sm text-gray-600 dark:text-gray-400">
        © 2025 DevsBook - Conectando desenvolvedores ao redor do mundo
    </p>
</footer>

<div class="modal fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="card-light dark:card-dark rounded-2xl p-6 max-w-md w-full mx-4 relative transform scale-95 transition-transform duration-300">
        <a data-modal-close class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-xl cursor-pointer transition-colors duration-200">&times;</a>
        <div class="modal-content"></div>
    </div>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
    // Configuração do tema
    const toggle = document.getElementById('theme-toggle');
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
    const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme.matches ? 'dark' : 'light');

    if (currentTheme === 'dark') {
        document.body.classList.remove('theme-light');
        document.body.classList.add('theme-dark');
        document.documentElement.classList.add('dark');
        if (toggle) toggle.checked = true;
    } else {
        document.body.classList.remove('theme-dark');
        document.body.classList.add('theme-light');
        document.documentElement.classList.remove('dark');
        if (toggle) toggle.checked = false;
    }

    if (toggle) {
        toggle.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.remove('theme-light');
                document.body.classList.add('theme-dark');
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('theme-dark');
                document.body.classList.add('theme-light');
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
    }

    // Modal personalizado
    function openModal(content) {
        const modal = document.querySelector('.modal');
        const modalContent = document.querySelector('.modal-content');
        modalContent.innerHTML = content;
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        document.querySelector('.modal > div:last-child').classList.remove('scale-95');
        document.querySelector('.modal > div:last-child').classList.add('scale-100');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.querySelector('.modal');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.classList.add('opacity-0', 'pointer-events-none');
        document.querySelector('.modal > div:last-child').classList.remove('scale-100');
        document.querySelector('.modal > div:last-child').classList.add('scale-95');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('click', function(e) {
        if (e.target.hasAttribute('data-modal-close') || e.target.closest('[data-modal-close]')) {
            closeModal();
        }

        if (e.target.classList.contains('modal')) {
            closeModal();
        }

        // Abrir modal com links que tenham rel="modal:open"
        if (e.target.hasAttribute('rel') && e.target.getAttribute('rel') === 'modal:open') {
            e.preventDefault();
            const target = e.target.getAttribute('href');
            const content = document.querySelector(target).innerHTML;
            openModal(content);
        }
    });

    // Tecla ESC para fechar modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Seu script.js original com melhorias
    function setActiveTab(tab) {
        document.querySelectorAll('.tab-item').forEach(function(e){
            if(e.getAttribute('data-for') == tab) {
                e.classList.add('active');
            } else {
                e.classList.remove('active');
            }
        });
    }

    function showTab() {
        if(document.querySelector('.tab-item.active')) {
            let activeTab = document.querySelector('.tab-item.active').getAttribute('data-for');
            document.querySelectorAll('.tab-body').forEach(function(e){
                if(e.getAttribute('data-item') == activeTab) {
                    e.style.display = 'block';
                } else {
                    e.style.display = 'none';
                }
            });
        }
    }

    if(document.querySelector('.tab-item')) {
        showTab();
        document.querySelectorAll('.tab-item').forEach(function(e){
            e.addEventListener('click', function(r) {
                setActiveTab( r.target.getAttribute('data-for') );
                showTab();
            });
        });
    }

    // Feed input
    const feedInputPlaceholder = document.querySelector('.feed-new-input-placeholder');
    const feedInput = document.querySelector('.feed-new-input');

    if (feedInputPlaceholder && feedInput) {
        feedInputPlaceholder.addEventListener('click', function(obj){
            obj.target.style.display = 'none';
            feedInput.style.display = 'block';
            feedInput.focus();
            feedInput.innerText = '';
        });

        feedInput.addEventListener('blur', function(obj) {
            let value = obj.target.innerText.trim();
            if(value == '') {
                obj.target.style.display = 'none';
                feedInputPlaceholder.style.display = 'block';
            }
        });
    }

    // Mostrar/ocultar senha
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Efeitos de foco nos inputs
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-primary-500');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-primary-500');
        });
    });

    // Animações de entrada para elementos
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card-light, .card-dark').forEach(card => {
        observer.observe(card);
    });

    // Melhorias para o tema dark - validação visual de formulários
    document.querySelectorAll('input, textarea, select').forEach(element => {
        element.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-primary-500');
        });

        element.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-primary-500');
        });
    });
</script>
</body>
</html>