<?php
use TouchYourPass\Utils;

require 'inc/init.php';

// Service
//--------

if (in_array($_SERVER['REQUEST_URI'], array('/', '/index.php'))) {
    header('Location: ' . Utils::serverUrl('/index.php/'));
    exit;
} else if ($_SERVER['REQUEST_URI'] === '/index.php/') {
    include 'partial/login.php';
} else if ($_SERVER['REQUEST_URI'] === '/index.php/keystore') {
    include 'partial/keystore.php';
} else if ($_SERVER['REQUEST_URI'] === '/index.php/register') {
    include 'partial/register.php';
}  else if ($_SERVER['REQUEST_URI'] === '/index.php/users') {
    include 'partial/users.php';
} else {
    http_response_code(404);
    $smarty->display('404.tpl');
}
