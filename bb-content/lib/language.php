<?php
require_once __DIR__ . '/../lib/vendor/spyc/Spyc.php';

/*
 * Language class, takes an associative array of translations,
 * enables to easily get strings in the array.
 *
 * $lang = new Language($myArr);
 * echo $lang->get('somekey');
 * echo $lang->get('installation.title'); // gets $arr['installation']['title']
 * echo $lang->get('key', array('name', 'mike')); // if the value is "Hello {{name}}" returns "Hello mike"
 */
class Language
{
    private $lang;

    public function __construct($lang) {
        if(is_array($lang)) {
            $this->lang = $lang;
        } elseif (is_string($lang)) {
            $this->lang = Spyc::YAMLLoad(__DIR__ . '/../lang/' . $lang . '.yml');
        } else {
            throw new InvalidArgumentException('Invalid argument, must be a string or an array');
        }
    }

    /*
     * Seeks for the key in the language array and returns it's value, or
     * the key itself if it was not found.
     */
    public function get($key, $values = null) {
        // get the configured language
        $lang = $this->lang;

        // for each separation, seek for nested arrays
        foreach(explode('.', $key) as $current_key) {
            if(array_key_exists($current_key, $lang)) {
                // if found, keep going
                $lang = $lang[$current_key];
            } else {
                // if not, return the key
                return $key;
            }
        }
    
        // if the value is invalid (it's an array), return the key
        if(is_array($lang)) {
            return $key;
        }

        if(is_array($values)) {
            foreach($values as $key => $val) {
                $lang = preg_replace('/{{\s*(.*?)\s*}}/i', $val, $lang);
            }
        }
    
        // return the found value
        return $lang;
    }
}
