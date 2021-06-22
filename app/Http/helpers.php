<?php

if (! function_exists('get_cookie')) {
    function get_cookie($cookie)
    {
        return isset($_COOKIE[$cookie])?$_COOKIE[$cookie]:'';
    }
}
if (! function_exists('remove_cookie')) {
    function remove_cookie($cookie)
    {
        if (isset($_COOKIE[$cookie])) {
            unset($_COOKIE[$cookie]); 
            return true;
        } else {
            return false;
        }
    }
}