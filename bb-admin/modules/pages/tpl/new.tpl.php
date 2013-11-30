<?php get_admin_header(); ?>

<?php get_admin_sidebar(); ?>

<div id="dashboard-content-container" class="pure-u-1">
    <div id="dashboard-content">
        <h1>Create new page</h1>

        <form class="pure-form pure-form-aligned">
            <input class="pure-input-1" id="name" type="text" placeholder="Title">

            <textarea class="pure-input-2-3" id="content" name="content" placeholder="Lorem ipsum dolor sit amet..." rows="10" cols="30"></textarea>

            <button type="submit" class="pure-button pure-button-primary pure-input-1">
                <i class="fa fa-plus"></i>
                Create
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
