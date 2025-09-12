<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Usuario;
use Core\Database;
use Core\Validacao;

class LoginController
{
    public function index()
    {
        return view('login', template: 'guest');
    }

    public function login()
    {
        $email = request()->post('email');
        $senha = request()->post('senha');

        $validacao = Validacao::validar([
            'email' => ['required', 'email'],
            'senha' => ['required'],
        ], request()->all());

        if ($validacao->naoPassou()) {
            return view('login', template: 'guest');
        }

        $database = new Database(config('database'));

        $usuario = $database->query(
            query: ' select * from usuarios where email = :email',
            class: Usuario::class,
            params: compact('email')
        )->fetch();

        if (! ($usuario && password_verify($senha, $usuario->senha))) {
            flash()->push('validacoes', ['email' => ['Usuário ou senha estão incorretos!']]);

            return view('login', template: 'guest');
        }

        session()->set('auth', $usuario);

        flash()->push('mensagem', 'Seja bem-vindo ' . $usuario->nome . '!');

        return redirect('/notas');
    }
}
