<?php

namespace src;

use PDO;
use PDOException;

/**
 * Class Database
 */
class Database{

    private static $db;

    /**
     * @return PDO
     */
    public static function getConnection(){

        $config = Config::load();
        $dbConfig = $config['db'];

        if(!self::$db){
            try {

                $dsn = 'mysql:host=' . $dbConfig['host']. ';dbname=' . $dbConfig['dbname'];
                $settings = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );

                self::$db = new PDO($dsn, $dbConfig['username'], $dbConfig['passwd'], $settings);
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        return self::$db;
    }
}