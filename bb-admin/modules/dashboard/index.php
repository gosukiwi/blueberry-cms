<?php
if(!defined('BB-ADMIN')) die('This file cannot be accessed directly.');

if(!@$_SESSION['logged']) {
    redirect('bb-admin/?module=dashboard&action=login');
}

require_once __DIR__ . '/tpl/index.tpl.php';

