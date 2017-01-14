<?php

namespace System;

/**
 * Class Config
 * @package System
 */
class Config
{

    /**
     * @var array
     */
    private static $cache = [];

    /**
     * @param $name
     * @param $key
     * @param null $default
     * @return array|string|int|bool|float|null
     */
    public static function get($name, $key, $default = null)
    {

        if (isset(self::$cache[$name]) === false) {
            static::$cache = include_once APP_ROOT . '/config/' . $name . '.php';
        }

        $values = static::$cache;

        $key = (array)$key;

        foreach ($key as $item) {
            if (isset($values[$item])) {
                $values = $values[$item];
            } else {
                return $default;
            }
        }

        return $values;
    }

}