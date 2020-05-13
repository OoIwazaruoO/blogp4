<?php

namespace Core;

class DBFactory
{
    public static function getMysqlConnexionWithPDO()
    {
        return new \PDO('mysql:host=localhost;dbname=jforteroche;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    }
}
