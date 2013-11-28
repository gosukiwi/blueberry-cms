<?php
define('BB-ADMIN', true);

if(!$_SESSION['logged']) {
    require_once 'themes/default/login.tpl.php';
}
