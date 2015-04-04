<?php

use TouchYourPass\Utils;

if (empty($_SESSION['user'])) {
    header('Location: ' . Utils::serverUrl());
    exit;
}

$smarty->assign('user', $_SESSION['user']);
$smarty->display('keystore.tpl');