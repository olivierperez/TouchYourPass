<?php
namespace TouchYourPass\service;

use TouchYourPass\Utils;

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

    public function install($data) {
        $fields = $this->fields;

        $fields['Database configuration']['DB_CONNECTIONSTRING']['value'] = $data->dbConnectionString;
        $fields['Database configuration']['DB_USER']['value'] = $data->dbUser;
        $fields['Database configuration']['DB_PASSWORD']['value'] = $data->dbPassword;

        $fields['Passphrase']['PASSPHRASE_SALT']['value'] = $data->salt;

        $fields['Allow visitors to register']['ALLOW_REGISTER']['value'] = isset($data->allowRegister) && in_array($data->allowRegister, array('on', 'true', '1'));

        $content = '<?php' . "\n";
        // Loop on sections
        foreach ($fields as $sKey => $section) {
            // Write section title
            $content .= '// ' . $sKey . "\n";

            // Loop on constants
            foreach ($section as $var => $value) {
                // Write constant
                if ($value['type'] == 'String') {
                    $content .= 'const ' . $var . ' = \'' . $value['value'] . "';\n";
                } elseif ($value['type'] == 'bool') {
                    $content .= 'const ' . $var . ' = ' . ($value['value'] ? 'true' : 'false') . ";\n";
                }
            }
            $content .= "\n";
        }

        //file_put_contents(CONF_FILENAME, $content);

        return array('msg' => __f('Installation', 'Ended', Utils::serverUrl()));
    }
}
