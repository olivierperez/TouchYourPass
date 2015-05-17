<?php

use TouchYourPass\Utils;

define('ROOT_DIR', dirname(__FILE__));

require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/inc/const.php';
require ROOT_DIR . '/inc/i18n.php';
require ROOT_DIR . '/vendor/o80/i18n/src/shortcuts.php';
require ROOT_DIR . '/inc/smarty.php';

if (file_exists(ROOT_DIR. '/inc/conf.php')) {
    header(('Location: ' . Utils::serverUrl()));
    exit;
}

$smarty->assign('currentPage', 'install');
$smarty->assign('loggedIn', false);
$smarty->assign('hideNavBar', true);
$smarty->display('install.tpl');