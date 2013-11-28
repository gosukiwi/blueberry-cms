<?php
require_once __DIR__ . '/../../bb-content/lang/en_us.php';

class LanguageTest extends PHPUnit_Framework_TestCase
{
    public function testLanguage() {
        $this->assertEquals('invalid key', __('invalid key'));
        $this->assertEquals('Installing Blueberry', __('install.title'));
    }
}
