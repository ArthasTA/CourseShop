<?php

namespace System;

/**
 * Class Config
 * @package System
 */
class Config
{

    /**
     * @param null $default
     * @return array|null
     */
    public static function get($url,$default = null)
    {
        $urlParts = explode('/', $url);
        $values = include_once APP_ROOT . 'config/router.php';

        $subject = $urlParts[0];
        $pattern = '/^api/';
        preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);

        if ($matches == true){
            $key = 'patterns';
        } else {
            $key = 'urls';
        }

        $rules = array();
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