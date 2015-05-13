<?php
namespace TouchYourPass\api;

class InstallApi extends Api {

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

    function onPost() {
        $data = json_decode($_POST['data']);
        $this->fields['Database configuration']['DB_CONNECTIONSTRING']['value'] = $data->dbConnectionString;
        $this->fields['Database configuration']['DB_USER']['value'] = $data->dbUser;
        $this->fields['Database configuration']['DB_PASSWORD']['value'] = $data->dbPassword;

        $this->fields['Passphrase']['PASSPHRASE_SALT']['value'] = $data->salt;

        $this->fields['Allow visitors to register']['ALLOW_REGISTER']['value'] = !!$data->allowRegister;

        return $this->fields;
    }

    function onGet() {
        return $this->badRequest();
    }

    function onDelete() {
        return $this->badRequest();
    }
}
