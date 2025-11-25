<?php

if (!function_exists('setting')) {
    function setting($key, $value = null)
    {
        if ($value === null) {
            return \App\Models\Setting::get($key);
        }

        return \App\Models\Setting::set($key, $value);
    }
}

