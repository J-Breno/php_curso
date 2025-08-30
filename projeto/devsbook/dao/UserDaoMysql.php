<?php

require_once "models/user.php";

class UserDaoMysql implements UserDAO
{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function findByToken($token)
    {

    }
}