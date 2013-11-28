<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class InstallTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp() {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/blueberry-cms/');
    }

    public function testTitle() {
        $this->url('install.php');
        $this->assertEquals('Installing Blueberry', $this->title());
    }
}
