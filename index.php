<?php
// Entry point of Blueberry CMS
define('BB-ROOT', true);

require_once('bb-content/index.php');

require_once 'bb-content/lib/database.php';
$db = new Database();
// insert
// $db->table('test')->insert(array('name' => 'pepeitoh'));
$first = $db->table('test')->find(2);
var_dump($first);

$all = $db->table('test')->filter();
var_dump($all);

var_dump($db->count());
