<?php
use TouchYourPass\ServiceFactory;

define('ROOT_DIR', dirname(__FILE__) . '/..');
require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/inc/const.php';
require ROOT_DIR . '/inc/conf.php';
require ROOT_DIR . '/inc/i18n.php';
require ROOT_DIR . '/vendor/o80/i18n/src/shortcuts.php';
require ROOT_DIR . '/vendor/ircmaxell/password-compat/lib/password.php';
require ROOT_DIR . '/inc/smarty.php';

//session_start();
$session = new o80\Session();
$session->start();

// Init DB connection
$pdo = new PDO(DB_CONNECTIONSTRING, DB_USER, DB_PASSWORD);
$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
ServiceFactory::init($pdo);