<?php 

if (!function_exists('arrayToStringRoles')) {
    function arrayToStringRoles(array $array): string
    {
        return implode('|', $array);
    }
}