<?php $validacoes = flash()->get('validacoes'); ?>

<div class="bg-base-300 rounded-box w-full text-3xl font-bold pt-20 overflow-hidden flex flex-col items-center">
    <form action="/mostrar" method="POST" class="max-w-md flex flex-col gap-4">
        <div class="text-center">Digite a sua senha novamente para começar a ver todas as suas notas descriptografadas</div>

        <label class="form-control">
            <div class="label">
                <span class="label-text text-sm">Senha</span>
            </div>

            <input type="password" name="senha" class="input input-bordered w-full" />

            <?php if (isset($validacoes['senha'])) { ?>
                <div class="mt-1 text-xs text-error"><?= $validacoes['senha'][0] ?></div>
            <?php } ?>
        </label>

        <button class="btn btn-primary">Abrir minhas notas</button>
    </form>
</div>