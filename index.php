<?php
use TouchYourPass\Utils;

require 'inc/init.php';

// Service
//--------

if ($_SERVER['REQUEST_URI'] === '/') {
    header('Location: ' . Utils::serverUrl() . '/index.php/');
    exit;
} else if ($_SERVER['REQUEST_URI'] === '/index.php/') {
    include 'partial/home.php';
} else if ($_SERVER['REQUEST_URI'] === '/index.php/keystore') {
    include 'partial/keystore.php';
} else {
    http_response_code(404);
    $smarty->display('404.tpl');
}
