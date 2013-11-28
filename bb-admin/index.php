<?php
define('BB-ADMIN', true);

// Enable sessions
session_start();
// Start output buffering
ob_start();

if(!@$_SESSION['logged']) {
    require_once 'themes/default/login.tpl.php';
}
