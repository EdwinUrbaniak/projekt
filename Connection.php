<?php

/**
 * Class Connection
 */
class Connection
{
    public static function getConnection()
    {
        static $connection = null;
        if ($connection === null) {
            $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        }
        return $connection;
    }
}