<?php get_admin_header(); ?>

<?php get_admin_sidebar(); ?>

<div id="dashboard-content-container" class="pure-u-1">
    <div id="dashboard-content">
        <h1><?php echo __('admin.dashboard.welcome', array('user' => bb('username'))); ?></h1>
        <p><?php echo __('admin.dashboard.welcome_message'); ?></p>

        <h2>Stats</h2>
        <div class="pure-g">
            <div class="pure-u-1-2">
                <strong>Most visited pages</strong>
                <ul>
                    <li>Some page</li>
                    <li>Some page</li>
                    <li>Some page</li>
                </ul>
            </div>
            <div class="pure-u-1-2">
                <strong>Hits this week</strong>
                <ul>
                    <li>121 Today</li>
                    <li>100 Yesterday</li>
                    <li>111 on Monday</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php get_admin_footer(); ?>
