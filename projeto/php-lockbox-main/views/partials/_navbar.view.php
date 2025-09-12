<div class="navbar bg-base-100 shadow-sm">
    <div class="flex-1">
        <a href="/notas" class="btn btn-ghost text-xl">LockBox</a>
    </div>

    <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <li>
                <?php if (session()->get('mostrar')) { ?>
                    <a href="/esconder">🫣</a>
                <?php } else { ?>
                    <a href="/confirmar">👀</a>
                <?php } ?>
            </li>
            <li>
                <details>
                    <summary><?= auth()->nome ?></summary>
                    <ul class="bg-base-100 rounded-t-none p-2">
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </details>
            </li>
        </ul>
    </div>
</div>