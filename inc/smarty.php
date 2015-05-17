<?php
use TouchYourPass\Utils;

require_once ROOT_DIR . '/vendor/smarty/smarty/libs/Smarty.class.php';
$smarty = new \Smarty();
$smarty->setTemplateDir(ROOT_DIR . '/tpl/');
$smarty->setCompileDir(ROOT_DIR . '/tpl_c/');
$smarty->setCacheDir(ROOT_DIR . '/cache/smarty');
$smarty->caching = false;

$smarty->assign('APPLICATION_NAME', __('Title', 'TouchYourPass'));
$smarty->assign('SERVER_URL', Utils::serverUrl());
$smarty->assign('SCRIPT_NAME', $_SERVER['SCRIPT_NAME']);
$smarty->assign('CONF_ALLOW_REGISTER', @ALLOW_REGISTER);

function smarty_modifier_html($html) {
    return Utils::htmlEscape($html);
}

function smarty_modifier_resource($link) {
    return Utils::serverUrl($link);
}

function smarty_modifier_page($page) {
    return Utils::serverUrl('index.php/' . $page);
}

function smarty_function_cond($params, Smarty_Internal_Template $template) {
    $if = $params['if'];

    return $if ?
        (isset($params['then']) ? $params['then'] : '') :
        (isset($params['else']) ? $params['else'] : '');
}
