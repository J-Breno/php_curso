<?php

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $birthdate;
    public $city;
    public $work;
    public $avatar;
    public $cover;
    public $token;
}

interface UserDAO {
    public function findByToken($token);
    function findByEmail($email);
    function update(User $u);
    function insert(User $u);
}