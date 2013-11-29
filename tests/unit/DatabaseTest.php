<?php
require_once __DIR__ . '/../../bb-content/lib/database.php';

class DatabaseTest extends PHPUnit_Framework_TestCase
{
    private $db;

    public function setUp() {
        $this->db = new Database('test');
    }

    public function tearDown() {
        $this->rmdir(__DIR__ . '/../../bb-content/data/test/');
    }

    /*
     * Test basic CRUD
     */
    public function testCRUD() {
        $db = $this->db;

        // test for creation
        $this->assertNotNull($db);

        // test insert
        $db->table('test-table')->insert(array(
            'name' => 'Mike',
            'age' => 18,
            'gender' => 'Male'
        ));
        $this->assertTrue(file_exists(__DIR__ . '/../../bb-content/data/test/test-table/entry_1.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../bb-content/data/test/test-table/meta.php'));

        // test retrieve
        $user = $db->table('test-table')->find(1);
        $this->assertEquals($user['name'], 'Mike');
        $this->assertEquals($user['age'], 18);
        $this->assertEquals($user['gender'], 'Male');

        // test count
        $this->assertEquals($db->table('test-table')->count(), 1);

        // test remove
        $db->table('test-table')->remove(1);
        $this->assertEquals($db->table('test-table')->count(), 0);
    }

    /*
     * A more sophisticated test focused on data retrieval
     */
    public function testRetrieval() {
        $db = $this->db;

        for($i = 1; $i <= 20; $i++) {
            $db->table('test-table')->insert(array(
                'title' => 'Entry ' . $i,
                'author' => 'Author ' . $i,
            ));
        }

        $this->assertEquals($db->table('test-table')->count(), 20);

        // test retrieve normally
        $all = $db->table('test-table')->all();
        $this->assertEquals(count($all), 20);
        $this->assertEquals($all[0]['title'], 'Entry 1');

        // test with desc order
        $all = $db->table('test-table')->order('DESC')->all();
        $this->assertEquals(count($all), 20);
        $this->assertEquals($all[0]['title'], 'Entry 20');

        // test limit and offset
        $all = $db->table('test-table')->limit(10)->order('DESC')->all();
        $this->assertEquals(count($all), 10);
        $this->assertEquals($all[0]['title'], 'Entry 20');
        $this->assertEquals($all[9]['title'], 'Entry 11');

        // get desc order, offset of 5 with a limit of 10
        $all = $db->table('test-table')->offset(5)->limit(10)->order('DESC')->all();
        $this->assertEquals(count($all), 10);
        $this->assertEquals($all[0]['title'], 'Entry 15');
        $this->assertEquals($all[9]['title'], 'Entry 6');

        // get asc order, offset of 5, limit of 10
        $all = $db->table('test-table')->offset(5)->limit(10)->all();
        $this->assertEquals(count($all), 10);
        $this->assertEquals($all[0]['title'], 'Entry 6');
        $this->assertEquals($all[9]['title'], 'Entry 15');

        // test filter
        $entries = $db->table('test-table')->filter(array('title' => 'Entry 1'));
        $this->assertEquals(count($entries), 1);
        $this->assertEquals($entries[0]['title'], 'Entry 1');
        $this->assertEquals($entries[0]['author'], 'Author 1');

        // test update
        $first = $db->table('test-table')->find(1);
        $this->assertNotNull($first);
        $first['new-val'] = 12;
        $db->update(1, $first);
        $retrieve = $db->table('test-table')->find(1);
        $this->assertEquals(12, $retrieve['new-val']);
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
