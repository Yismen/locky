<?php

if (!function_exists('locky_assets')) {
    function locky_assets($path, $secure = null)
    {
        return asset('vendor/dainsys/locky/' . $path, $secure);
    }
}
