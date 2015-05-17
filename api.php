<?php

use TouchYourPass\api\ApiError;
use TouchYourPass\api\EntryApi;
use TouchYourPass\api\GroupApi;
use TouchYourPass\api\LoginApi;
use TouchYourPass\api\UserApi;

require 'inc/init.php';


header('Content-Type: application/json');
ob_start('fatal_error_handler');

// Functions
//----------
function fatal_error_handler($buffer) {
    $error = error_get_last();

    if ($error['type'] == 1) {
        http_response_code(500);
        return json_encode(new ApiError('Internal error', $error['message'], null));
    } else {
       return $buffer;
    }
}

// Variables
//----------
$api = null;
$result = null;

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
    case 'login' :
        $api = new LoginApi();
        break;
    default:
        http_response_code(500);
        $result = new ApiError('Internal error', 'Unknown API', null);
        break;
}

if ($result == null) {
// Call right method
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
        default:
            http_response_code(500);
            $result = new ApiError('Internal error', 'Unknown method call', null);
            break;
    }
}

echo json_encode($result);

ob_end_flush();