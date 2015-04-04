<?php

use Gregwar\Captcha\CaptchaBuilder;
use ScriptaVolent\service\FloodService;

require 'inc/init.php';

// Service
//--------

if ($_SERVER['REQUEST_URI'] === '/') {
    include 'partial/home.php';
} else if (preg_match('#^/index.php/(\d+)$#', $_SERVER['REQUEST_URI'], $result)) {
    $id = $result[1];
    include 'partial/keystore.php';
} else {
    http_response_code(404);
    $smarty->display('404.tpl');
}
