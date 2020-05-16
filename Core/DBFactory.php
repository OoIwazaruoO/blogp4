<?php

namespace Core;

class DBFactory
{
    public static function getMysqlConnexionWithPDO()
    {
        return new \PDO('mysql:host=localhost;dbname=blogp4;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    }
}
