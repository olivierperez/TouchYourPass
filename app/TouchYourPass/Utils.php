<?php
namespace TouchYourPass;

class Utils {

    function __construct() {}

    public static function debug($object) {
        echo '<pre>' . print_r($object, true) . '</pre>';
    }

    public static function htmlEscape($html) {
        return htmlentities($html, ENT_HTML5 | ENT_QUOTES);
    }

    public static function serverUrl($path = '') {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $port = in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : ':' . $_SERVER['SERVER_PORT'];
        $dirname = dirname($_SERVER['SCRIPT_NAME']);
        $dirname = $dirname === '\\' ? '' : $dirname;
        $dirname = str_replace('/admin', '', $dirname);
        $server_name = $_SERVER['SERVER_NAME'] . $port . $dirname;
        $full = $server_name . $path;

        return $scheme . '://' .  preg_replace('#//+#', '/', $full);
    }

}
