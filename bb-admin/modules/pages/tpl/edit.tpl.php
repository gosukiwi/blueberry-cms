<?php get_admin_header(); ?>

<?php get_admin_sidebar(); ?>

<div id="dashboard-content-container" class="pure-u-1">
    <div id="dashboard-content">
        <h1><?php echo __('admin.pages.edit.title'); ?></h1>

        <?php if(!is_null($message)): ?>
            <?php echo $message; ?>
        <?php endif; ?>

        <form method="post" action="<?php echo bb('current_uri'); ?>" class="pure-form pure-form-aligned">
            <input class="pure-input-1" id="title" name="title" type="text" value="<?php echo $entry['title']; ?>" placeholder="<?php echo __('admin.pages.form_title'); ?>">
            <textarea class="pure-input-2-3" id="content" name="content"><?php echo $entry['content']; ?></textarea>
            <button type="submit" class="pure-button pure-button-primary pure-input-1">
                <i class="fa fa-pencil"></i>
                <?php echo __('admin.pages.edit.btn_edit'); ?>
            </button>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?php echo bb('admin_uri') . 'modules/shared/tpl/js/placeholder-polyfill.js'; ?>"></script>
<script type="text/javascript" src="<?php echo bb('admin_uri') . 'modules/pages/vendor/ckeditor/ckeditor.js'; ?>"></script>
<script type="text/javascript" src="<?php echo bb('admin_uri') . 'modules/pages/vendor/ckfinder/ckfinder.js'; ?>"></script>
<script type="text/javascript">
(function () {
    "use strict";

    var editor = CKEDITOR.replace(document.getElementById('content'), { 'height': '400px' });
    CKFinder.setupCKEditor(editor, <?php echo "'" . bb('admin_uri') . 'modules/pages/vendor/ckfinder/' . "'"; ?>);
} ());
</script>

<?php get_admin_footer(); ?>
