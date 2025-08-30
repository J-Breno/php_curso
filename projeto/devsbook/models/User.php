<?php

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $birthDate;
    public $city;
    public $work;
    public $avatar;
    public $cover;
    public $token;
}

interface UserDAO {
    public function findByToken($token);
}