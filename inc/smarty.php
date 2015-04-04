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

function smarty_modifier_html($html) {
    return Utils::htmlEscape($html);
}

function smarty_modifier_resource($link) {
    return Utils::serverUrl() . $link;
}
