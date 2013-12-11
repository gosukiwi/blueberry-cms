<?php get_admin_header(); ?>

<?php get_admin_sidebar(); ?>

<div id="dashboard-content-container" class="pure-u-1">
    <div id="dashboard-content">
        <h1><?php echo __('admin.menus.title'); ?></h1>

        <?php if(!is_null($message)): ?>
            <?php echo $message; ?>
        <?php endif; ?>

        <form method="post" action="<?php echo bb('current_uri'); ?>" class="pure-form pure-form-aligned">
            <input data-bind="value: link_name" class="pure-input-1" id="name" name="name" type="text" placeholder="<?php echo __('admin.menus.name'); ?>">
            <div class="pure-g">
                <div class="pure-u-1-5">
                    <select data-bind="options: types, value: current_type, optionsText: 'name'" class="pure-input-1" name="type">
                    </select>
                </div>
                <div class="pure-u-3-5">
                    <select data-bind="options: current_type().children, value: current_url, optionsText: 'name', optionsValue: 'url'" class="pure-input-1">
                    </select>
                </div>
                <div class="pure-u-1-5">
                    <button type="submit" data-bind="click: addLink" class="pure-input-1 pure-button pure-button-primary">
                        <i class="fa fa-plus"></i>
                        <?php echo __('admin.menus.add'); ?>
                    </button>
                </div>
            </div>

            <h2><?php echo __('admin.menus.links'); ?></h2>
            
            <ul data-bind="foreach: links" id="list-menu-items">
                <li>
                    <a target="_blank" data-bind="text: name, attr: { href: url }"></a>
                    <a data-bind="click: $root.moveUp"><i class="fa fa-arrow-up"></i></a>
                    <a data-bind="click: $root.moveDown"><i class="fa fa-arrow-down"></i></a>
                    <a data-bind="click: $root.removeLink"><i class="fa fa-times"></i></a>
                </li>
            </ul>

            <div class="form-buttons">
                <button type="submit" class="pure-button pure-button-primary">
                    <i class="fa fa-save"></i>
                    <?php echo __('admin.menus.save'); ?>
                </button>

                <a class="pure-button" href="<?php echo module_uri('pages'); ?>"><i class="fa fa-reply"></i> <?php echo __('admin.menus.btn_back'); ?></a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?php echo bb('admin_uri') . 'modules/shared/tpl/js/placeholder-polyfill.js'; ?>"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo bb('admin_uri') . 'modules/shared/tpl/js/knockout-3.0.0.js'; ?>"></script>
<script type="text/javascript">
// Global constants
var MENU_TYPES,
    AJAX_GET_MENU_ITEMS_URI;

(function (undefined) {
    "use strict";

    AJAX_GET_MENU_ITEMS_URI = '<?php echo ajax_uri('menus', 'get_menu_items') ?>';

    MENU_TYPES = [

<?php 
$entries = array();
foreach($menu_types as $type) {
    $items = array();
    foreach($type['children'] as $child) {
        $items[] = '{ name: "' . $child['name'] . '", url: "' . $child['url'] . '" }';
    }
    $entries[] = '{ name: "'.$type['name'].'", children: ['.implode(',', $items).'] }';
}
echo implode(',', $entries);
?>

    ,{ name: 'test', children: [{ name: 'a', url: "SOMEURL" }, { name: 'b', url: 'SOMEOTHERURL' }] }
    ];
} ());
</script>
<script type="text/javascript" src="<?php echo bb('admin_uri') . 'modules/menus/tpl/js/app.js'; ?>"></script>

<?php get_admin_footer(); ?>
