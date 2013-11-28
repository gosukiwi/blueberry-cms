<?php
// Helper functions to work with languages

/*
 * Seeks for the key in the language array and returns it's value, or
 * the key itself if it was not found.
 */
function __($key) {
    global $lang;

    $arr = $lang;
    // for each separation, seek for nested arrays
    foreach(explode('.', $key) as $current_key) {
        if(array_key_exists($current_key, $arr)) {
            // if found, keep going
            $arr = $arr[$current_key];
        } else {
            // if not, return the key
            return $key;
        }
    }

    // if the value is invalid (it's an array), return the key
    if(is_array($arr)) {
        return $key;
    }

    // return the found value
    return $arr;
}
