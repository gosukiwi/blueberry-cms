<?php
// Entry point of Blueberry CMS
define('BB-ROOT', true);

// Enable sessions
session_start();
// Start output buffering
ob_start();

require_once('bb-content/index.php');
