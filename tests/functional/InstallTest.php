<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class InstallTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp() {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/blueberry-cms/');
    }

    public function testSubmittingForm() {
        // set the test environment for the installation
        $this->url('install.php?env=test');

        // check title
        $this->assertEquals('Installing Blueberry', $this->title());

        // check inputs
        $username = $this->byName('username');
        $password = $this->byName('password');
        $language = $this->byName('language');
        $this->assertNotNull($username);
        $this->assertNotNull($password);
        $this->assertNotNull($language);

        // select the form
        $form = $this->byTag('form');

        // test with invalid values
        $username->value('');
        $password->value('');
        $language->value('en_us');
        $form->submit();

        $error_message = $this->byId('error-message');
        $this->assertContains('invalid', $error_message->byTag('h2')->text());

        // test completing with valid values
        $form = $this->byTag('form');
        $username = $this->byName('username');
        $password = $this->byName('password');
        $language = $this->byName('language');

        $username->value('admin');
        $password->value('1234');
        $language->value('en_us');
        $form->submit();

        $header = $this->byCssSelector('h1');
        $this->assertEquals('ok', $header->text());
    }
}
