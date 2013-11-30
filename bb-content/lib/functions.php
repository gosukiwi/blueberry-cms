<?php
/**
 * This file contains Blueberry helper functions
 */

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/language.php';

$db = new Database();
$config = $db->table('config')->find(1);

if(is_null($config)) {
    die('Blueberry was not installed properly.');
}

$lang = new Language($config['language']);

/**
 * Translates a given key using the configured language
 *
 * @param string $key the key to look for
 * @param array $values optional array of values to replace in the translated string
 * @return string a translated string using the configured language
 */
function __($key, $values = null) {
    global $lang;
    return $lang->get($key, $values);
}

/**
 * Helper function to get Blueberry configuration data
 *
 * Helper function to get Blueberry configuration data, besides the regular
 * configuration array it allows the following options
 *  * admin_theme_uri
 *  * theme_uri
 *
 *  @param string $key
 *  @return string
 */
function bb($key) {
    global $config;

    if(!array_key_exists($key, $config)) {
        switch($key) {
        case 'current_uri':
            return $_SERVER['REQUEST_URI'];
        case 'admin_theme_uri':
            return bb('admin_uri') . 'themes/' . bb('admin_theme') . '/';
        case 'theme_uri':
            return bb('base_uri') . '/bb-extensions/themes/' . bb('theme') . '/';
        }

        return null;
    }

    return $config[$key];
}

/**
 * Redirects
 *
 * @return void
 * @author Me
 **/
function redirect($path) {
    header('Location:' . bb('base_uri') . $path);
}

function lib($name) {
    if(is_array($name)) {
        foreach($name as $lib) {
            lib($lib);
        }
    } else {
        require_once __DIR__ . '/' . $name . '.php';
    }
}

function tpl($file, $vars = null) {
    if(is_array($vars)) {
       extract($vars);
    }

    require_once $file;
}

function either($a, $b) {
    if($a) return $a;
    return $b;
}
