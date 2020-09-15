<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

if (! function_exists('env')) {
    function env($key, $default = null)
    {
        return getenv($key) ?: $default;
    }
}

if (! function_exists('is_json')) {
    function is_json($string)
    {
        json_decode($string);
        return json_last_error() == JSON_ERROR_NONE;
    }
}
