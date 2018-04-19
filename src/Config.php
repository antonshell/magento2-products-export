<?php

namespace src;

/**
 * Class Config
 * @package src
 */
class Config
{
    /**
     * @return mixed
     */
    public static function load(){
        $data = require __DIR__ . '/../_config.php';
        return $data;
    }
}