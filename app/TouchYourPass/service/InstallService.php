<?php
namespace TouchYourPass\service;

class InstallService {

    private $fields = array(
        'Database configuration' =>
            array(
                'DB_CONNECTIONSTRING' => array('type' => 'String', 'default' => 'mysql:host=HOST;dbname=SCHEMA;port=3306'),
                'DB_USER' => array('type' => 'String', 'default' => 'root'),
                'DB_PASSWORD' => array('type' => 'String', 'default' => 'root')
            ),
        'Passphrase' =>
            array(
                'PASSPHRASE_SALT' => array('type' => 'String', 'default' => 'hBtjJzCpgg49RwxkSwVyJ3DzvGT57nKgrdRjK7p3R2')
            ),
        'Allow visitors to register' =>
            array(
                'ALLOW_REGISTER' => array('type' => 'bool', 'default' => true)
            )
    );

    function __construct() {
    }

    public function getDefaultFields() {
        return $this->fields;
    }
}
