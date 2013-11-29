<?php
if(!defined('BB-ADMIN')) die('This file cannot be accessed directly.');

$_SESSION['logged'] = null;
redirect('bb-admin/?module=dashboard&action=login');
