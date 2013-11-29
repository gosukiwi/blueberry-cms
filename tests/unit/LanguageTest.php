<?php
require_once __DIR__ . '/../../bb-content/lib/language.php';

class LanguageTest extends PHPUnit_Framework_TestCase
{
    private $language;

    public function setUp() {
        $lang['no-nesting'] = 'simple';
        $lang['test']['nested'] = 'hello, world';
        $lang['test']['onemore']['level'] = '1234';
        $lang['with-values'] = 'hello {{name}}';
        $lang['with-values-2'] = 'hello {{ name }}';
        $lang['with-values-3'] = 'hello {{name}}, replace it again {{name}}!';

        $this->language = new Language($lang);
    }

    public function testLanguage() {
        $lang = $this->language;

        $this->assertEquals('invalid key', $lang->get('invalid key'));
        $this->assertEquals('simple', $lang->get('no-nesting'));
        $this->assertEquals('hello, world', $lang->get('test.nested'));
        $this->assertEquals('1234', $lang->get('test.onemore.level'));
        // test with values
        $this->assertEquals('hello mike', $lang->get('with-values', array('name' => 'mike')));
        $this->assertEquals('hello mike', $lang->get('with-values-2', array('name' => 'mike')));
        $this->assertEquals('hello mike, replace it again mike!', $lang->get('with-values-3', array('name' => 'mike')));
    }

    public function testLoadingEnglish() {
        $lang = new Language('en_us');
        $this->assertEquals('Installing Blueberry', $lang->get('install.title'));
    }
}
