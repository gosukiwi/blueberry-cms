<?php
if(!defined('BB-ADMIN')) die('This file cannot be accessed directly.');

if($_POST) {
    $user = @$_POST['username'];
    $pass = @$_POST['password'];
    echo $user;

    if(bb('username') == $user && bb('password') == $pass) {
        $_SESSION['logged'] = $user;
        redirect('bb-admin/?module=dashboard');
    } else {
        // display error
    }
}

require_once __DIR__ . '/tpl/login.tpl.php';
