<?php
define('SCRIPT_START', microtime(true));

define('BB-ADMIN', true);

// Enable sessions
session_start();
// Start output buffering
ob_start();

// Include the template function helpers
require_once __DIR__ . '/../bb-content/lib/functions.php';

// Admin template extra helpers
function get_admin_header() {
    require_once __DIR__ . '/modules/shared/tpl/header.tpl.php';
}

function get_admin_footer() {
    require_once __DIR__ . '/modules/shared/tpl/footer.tpl.php';
}

function get_admin_sidebar() {
    require_once __DIR__ . '/modules/shared/tpl/sidebar.tpl.php';
}
// End of admin template headers

// Find the module and action
$module = isset($_GET['module']) ? $_GET['module'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$file = __DIR__ . '/modules/' . $module . '/' . $action . '.php';

// Try to load the module and action required
if(file_exists($file)) {
    require_once $file;
} else {
    require_once __DIR__ . '/modules/shared/invalid_module.php';
}

