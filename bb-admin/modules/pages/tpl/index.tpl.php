<?php get_admin_header(); ?>

<?php get_admin_sidebar(); ?>

<div id="dashboard-content-container" class="pure-u-1">
    <div id="dashboard-content">
        <h1><?php echo __('admin.pages.index.title'); ?></h1>

        <table class="pure-table pure-table-horizontal">
            <thead>
                <th>Id</th>
                <th>Title</th>
                <th>Created At</th>
                <th>Modified At</th>
                <th></th>
            </thead>
            <tbody>
            <?php foreach($entries as $entry): ?>
                <tr>
                    <td><?php echo $entry['id']; ?></td>
                    <td><?php echo $entry['title']; ?></td>
                    <td><?php echo date('d F, h:i a', $entry['created_at']); ?></td>
                    <td><?php echo date('d F, h:i a', $entry['updated_at']); ?></td>
                    <td>
                        <a class="pure-button pure-button-primary" href="<?php echo module_uri('pages', 'edit', array('id' => $entry['id'])); ?>"><i class="fa fa-pencil"></i> <?php echo __('admin.pages.index.edit_page'); ?></a>
                        <a class="pure-button" href="#"><i class="fa fa-times"></i> <?php echo __('admin.pages.index.delete_page'); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="option-buttons">
            <a class="pure-button pure-button-primary"><?php echo __('admin.pages.btn_create'); ?></a>
            <a class="pure-button"><?php echo __('admin.pages.btn_back'); ?></a>
        </div>

        <?php echo $pagination; ?>
    </div>
</div>

<?php get_admin_footer(); ?>
