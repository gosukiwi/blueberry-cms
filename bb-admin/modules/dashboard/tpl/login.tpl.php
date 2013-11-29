<?php get_admin_header(); ?>

<div id="content-container" class="pure-g">
    <div class="pure-u-1">
        <div id="login-box">
            <h1>Login</h1>
            <form method="post" action="<?php echo bb('current_uri'); ?>">
                <input type="text" name="username" placeholder="Username" />
                <input type="password" name="password" placeholder="Password" />
                <button class="pure-button pure-button-primary" type="submit">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<?php get_admin_footer(); ?>
