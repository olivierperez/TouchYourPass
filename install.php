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
    $fields = $installService->getDefaultFields();

    $fields['Database configuration']['DB_CONNECTIONSTRING']['value'] = $data->dbConnectionString;
    $fields['Database configuration']['DB_USER']['value'] = $data->dbUser;
    $fields['Database configuration']['DB_PASSWORD']['value'] = $data->dbPassword;

    $fields['Passphrase']['PASSPHRASE_SALT']['value'] = $data->salt;

    $fields['Allow visitors to register']['ALLOW_REGISTER']['value'] = isset($data->allowRegister) && in_array($data->allowRegister, array('on', 'true', '1'));

    $content = '<?php' . "\n";
    // Loop on sections
    foreach ($fields as $sKey => $section) {
        // Write section title
        $content .= '// ' . $sKey . "\n";

        // Loop on constants
        foreach ($section as $var => $value) {
            // Write constant
            if ($value['type'] == 'String') {
                $content .= 'const ' . $var . ' = \'' . $value['value'] . "';\n";
            } elseif ($value['type'] == 'bool') {
                $content .= 'const ' . $var . ' = ' . ($value['value'] ? 'true' : 'false') . ";\n";
            }
        }
        $content .= "\n";
    }

    file_put_contents(CONF_FILENAME, $content);

    $result = array('msg' => __f('Installation', 'Ended', Utils::serverUrl()));

    echo json_encode($result);
}