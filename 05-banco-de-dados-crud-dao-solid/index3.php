<?php
$hash = '$2y$10$M0NjO9Wg66onjKAFXb8tO.SY4s4EMKWZwX/1N55TyISDdHR2Dgg56';
$senha = '123456';

if(password_verify($senha, $hash)) {
    echo 'senha correta';
} else {
    echo 'senha errada';
}