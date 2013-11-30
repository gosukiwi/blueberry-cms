<div id="dashboard-menu-container" class="pure-u">
    <div id="dashboard-menu">
        <h1><i class="fa fa-file-o"></i> <?php echo __('admin.pages.title'); ?></h1>
        <ul>
            <li><a href="<?php echo bb('admin_uri'); ?>?module=pages&action=manage"><?php echo __('admin.pages.manage'); ?></a></li>
            <li><a href="<?php echo bb('admin_uri'); ?>?module=pages&action=new"><?php echo __('admin.pages.new'); ?></a></li>
        </ul>

        <h1><i class="fa fa-list-ul"></i> <?php echo __('admin.menus.title'); ?></h1>
        <ul>
            <li><a href="<?php echo bb('admin_uri'); ?>?module=menus&action=manage"><?php echo __('admin.menus.manage'); ?></a></li>
            <li><a href="<?php echo bb('admin_uri'); ?>?module=menus&action=manage"><?php echo __('admin.menus.new'); ?></a></li>
        </ul>
        
        <h1><i class="fa fa-user"></i> <?php echo __('admin.account.title'); ?></h1>
        <ul>
            <li><a href="<?php echo bb('admin_uri'); ?>?module=account&action=logout"><?php echo __('admin.account.logout'); ?></a></li>
        </ul>
    </div>
</div>
