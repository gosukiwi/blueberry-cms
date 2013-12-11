<?php
if(!defined('BB-ADMIN')) die('This file cannot be accessed directly.');

// load the database library
lib('database');

$message = null;

if($_POST) {
    die();
}

// The available types, for now, only pages, then read from extensions
$menu_types = array();

// Pages
$pages = $db->table('pages')->all();
$page_links = array();
foreach($pages as $page) {
    $page_links[] = array('name' => $page['title'], 'url' => 'SOMEURL');
}
$menu_types[] = array('name' => 'pages', 'children' => $page_links);

// Display template
tpl(__DIR__ . '/tpl/new.tpl.php', array(
    'message' => $message,
    'menu_types' => $menu_types,
));
