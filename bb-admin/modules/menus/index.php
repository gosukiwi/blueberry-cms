<?php

lib(array('database', 'pagination.inc'));

$db = new Database();

// pagination
$total = $db->table('menus')->count();
$per_page = 10;
$page = either(@$_GET['p'], 1);
$paginator = new Pagination();
// Configure paginator and paginate
$pagination = $paginator->total($total)
    ->per_page($per_page)
    ->page_name('p')
    ->ul_class('pure-paginator')
    ->link_class('pure-button')
    ->link_active_class('pure-button-active')
    ->paginate();

// Get entries
$entries = $db->table('menus')
    ->order('DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page)
    ->all();

tpl(__DIR__ . '/tpl/index.tpl.php', array(
    'entries' => $entries,
    'pagination' => $pagination,
));

