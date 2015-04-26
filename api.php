<?php

use TouchYourPass\api\EntryApi;
use TouchYourPass\api\GroupApi;
use TouchYourPass\api\UserApi;

require 'inc/init.php';

header('Content-Type: application/json');

// Variables
//----------
$api = null;

// Select API

switch ($_GET['s']) {
    case 'group' :
        $api = new GroupApi();
        break;
    case 'entry' :
        $api = new EntryApi();
        break;
    case 'user' :
        $api = new UserApi();
        break;
}


// Call right method
$result = null;
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $result = $api->onPost();
        break;
    case 'GET':
        $result = $api->onGet();
        break;
    case 'DELETE':
        $result = $api->onDelete();
        break;
}

echo json_encode($result);
