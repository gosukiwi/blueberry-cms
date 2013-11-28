<?php
// Load language
require_once __DIR__ . '/bb-content/lang/en_us.php';

if($_POST) {
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('install.title'); ?></title>

        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css">
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />

        <style type="text/css">
        body,
        .pure-g [class *= "pure-u"],
        .pure-g-r [class *= "pure-u"] {
            font-family: 'Lato', sans-serif;
        }
        
        div#header {
            background-color: #E4E7EC;
        }

        div#header div#header-menu {
            font-size: 13px;
            padding: 10px;
            text-align: right;
        }

        div#header div#header-menu ul {
            display: inline-block;
            padding: 0px;
            margin: 0px;
            list-style: none;
        }

        div#header div#header-menu ul li {
            display: inline-block;
            padding-left: 10px;
        }

        div#header div#header-menu ul li a {
            color: black;
        }

        div#header div#header-menu ul li a:hover {
            text-decoration: none;
        }

        div#header div#title h1 {
            font-weight: 300;
            padding-left: 25px;
        }

        div#container {
            width: 960px;
            margin: auto;
        }

        div#container div#content h1 {
            font-weight: 300;
        }
        </style>
    </head>
    <body>
        <div class="pure-g" id="header">
            <div class="pure-u-1-2" id="title">
                <h1><?php echo __('install.title'); ?></h1>
            </div>

            <div class="pure-u-1-2">
                <div id="header-menu">
                    <span>Language:</span>
                    <ul>
                        <li><a href="?lang=en_us">English</a></li>
                        <li><a href="?lang=es_ar">Spanish</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="pure-g" id="container">
            <div class="pure-u-1">
                <div id="content">
                    <h1><?php echo __('install.settings'); ?></h1>
                    <form action="install.php" method="post" class="pure-form pure-form-aligned">
                        <fieldset>
                            <div class="pure-control-group">
                                <p><?php echo __('install.section_1_desc'); ?></p>
                            </div>

                            <div class="pure-control-group">
                                <label for="name"><?php echo __('install.username'); ?></label>
                                <input class="pure-input-1-2" id="name" name="username" type="text" placeholder="<?php echo __('install.username'); ?>">
                            </div>

                            <div class="pure-control-group">
                                <label for="name"><?php echo __('install.password'); ?></label>
                                <input class="pure-input-1-2" id="name" name="username" type="password" placeholder="<?php echo __('install.password'); ?>">
                            </div>

                            <div class="pure-control-group">
                                <p><?php echo __('install.section_2_desc'); ?></p>
                            </div>

                            <div class="pure-control-group">
                                <label for="password"><?php echo __('install.language'); ?></label>
                                <select id="language" name="language" class="pure-input-1-2">
                                    <option value="en_us">English</option>
                                    <option value="es_ar">Español</option>
                                </select>
                            </div>

                            <div class="pure-controls">
                                <button type="submit" class="pure-button pure-button-primary">
                                    <i class="fa fa-wrench"></i>
                                    <?php echo __('install.btn_install'); ?>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        </body>
        </html>
