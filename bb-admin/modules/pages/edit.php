<?php
if(!defined('BB-ADMIN')) die('This file cannot be accessed directly.');

// load the database library
lib('database');

$db = new Database();
$entry = $db->table('pages')->find((int)$_GET['id']);
if(is_null($entry)) {
    die('Invalid entry');
}

$message = null;

if($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $errors = array();

    if(empty($title)) {
        $errors[] = __('admin.pages.errors.title');
    }

    if(empty($content)) {
        $errors[] = __('admin.pages.errors.content');
    }

    if(count($errors) == 0) {
        $entry['title'] = $title;
        $entry['content'] = $content;
        $entry['updated_at'] = time();
        $db->table('pages')->update($entry['id'], $entry);
        $message = __('admin.pages.edit.success');
    }
}

tpl(__DIR__ . '/tpl/edit.tpl.php', array(
    'message' => $message,
    'entry' => $entry,
));
