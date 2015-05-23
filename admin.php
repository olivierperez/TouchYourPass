<?php
use TouchYourPass\Utils;

require 'inc/init.php';

$smarty->assign('loggedIn', !empty($_SESSION['user']) && !empty($_SESSION['user']->id));

if (in_array($_SERVER['REQUEST_URI'], array('/admin.php'))) {
    header('Location: ' . Utils::serverUrl('/admin.php/users'));
    exit;
} else if ($_SERVER['REQUEST_URI'] === '/admin.php/users') {
    $smarty->assign('currentPage', 'users');
    include 'partial/users.php';
} else {
    http_response_code(404);
    $smarty->display('404.tpl');
}
