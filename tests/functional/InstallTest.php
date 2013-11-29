<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class InstallTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp() {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/blueberry-cms/');
    }

    protected function tearDown() {
        $this->rmdir(__DIR__ . '/../../bb-content/data/test/');
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

        $message = $this->byId('success-message')->text();
        $this->assertContains('installed', $message);
    }

    private function rmdir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }

        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->rmdir($file);
            } else {
                unlink($file);
            }
        }

        rmdir($dirPath);
    }
}
