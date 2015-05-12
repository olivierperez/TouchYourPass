<?php
use TouchYourPass\Utils;

require 'inc/init.php';

$smarty->assign('ALLOW_REGISTER', ALLOW_REGISTER);
$smarty->assign('loggedIn', !empty($_SESSION['user']) && !empty($_SESSION['user']->id));

if (in_array($_SERVER['REQUEST_URI'], array('/', '/index.php'))) {
    header('Location: ' . Utils::serverUrl('/index.php/'));
    exit;
} else if ($_SERVER['REQUEST_URI'] === '/index.php/') {
    $smarty->assign('currentPage', 'home');
    include 'partial/home.php';
} else if ($_SERVER['REQUEST_URI'] === '/index.php/login') {
    $smarty->assign('currentPage', 'login');
    include 'partial/login.php';
} else if ($_SERVER['REQUEST_URI'] === '/index.php/keystore') {
    $smarty->assign('currentPage', 'keystore');
    include 'partial/keystore.php';
} else if ($_SERVER['REQUEST_URI'] === '/index.php/logout') {
    unset($_SESSION['user']);
    header('Location: ' . Utils::serverUrl('/index.php/'));
    exit;
} else if (ALLOW_REGISTER && $_SERVER['REQUEST_URI'] === '/index.php/register') {
    $smarty->assign('currentPage', 'register');
    include 'partial/register.php';
}  else if ($_SERVER['REQUEST_URI'] === '/index.php/users') {
    include 'partial/users.php';
} else {
    http_response_code(404);
    $smarty->display('404.tpl');
}
