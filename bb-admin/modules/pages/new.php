<?php
if(!defined('BB-ADMIN')) die('This file cannot be accessed directly.');

if($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
}

require_once __DIR__ . '/tpl/new.tpl.php';
