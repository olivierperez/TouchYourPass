<?php

use TouchYourPass\service\InstallService;
use TouchYourPass\Utils;

define('ROOT_DIR', dirname(__FILE__));
define('CONF_FILENAME', ROOT_DIR . '/inc/conf.php');

require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/inc/const.php';
require ROOT_DIR . '/inc/i18n.php';
require ROOT_DIR . '/vendor/o80/i18n/src/shortcuts.php';
require ROOT_DIR . '/inc/smarty.php';

if (file_exists(CONF_FILENAME)) {
    header(('Location: ' . Utils::serverUrl()));
    exit;
}

if (empty($_POST)) {

    $smarty->assign('currentPage', 'install');
    $smarty->assign('loggedIn', false);
    $smarty->assign('hideNavBar', true);
    $smarty->display('install.tpl');

} else {

    $installService = new InstallService();

    $data = json_decode($_POST['data']);
    $result = $installService->install($data);

    echo json_encode($result);

}