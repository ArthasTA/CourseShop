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
     * @param null $default
     * @return array|null
     */
    public static function get($url,$default = null)
    {
        $urlParts = explode('/', $url);
        $rules = array();
        $name = 'router';
        $key = 'urls';

        if (isset(self::$cache[$name]) === false) {
            static::$cache = include_once APP_ROOT . 'config/' . $name . '.php';
        }

        $values = static::$cache;
        $key = (array)$key;

        foreach ($key as $item) {
            if (isset($values[$item])) {
                $values = $values[$item];
                foreach ($values as $currentUrl => $rule) {
                    if ($urlParts[0] === $currentUrl) {
                        $rules ['controller'] = $rule['controller'];
                        $rules ['action'] = $rule['action'] . 'Action';
                    }
                }
            } else {
                return $default;
            }
        }
        return $rules;
    }

}