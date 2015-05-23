<?php
namespace TouchYourPass\service;

use TouchYourPass\Utils;

class InstallService {

    private $fields = array(
        'Database configuration' =>
            array(
                'DB_CONNECTIONSTRING' => array('type' => 'String', 'default' => 'mysql:host=HOST;dbname=SCHEMA;port=3306'),
                'DB_USER' => array('type' => 'String', 'default' => 'root'),
                'DB_PASSWORD' => array('type' => 'String', 'default' => 'root'),
                'DB_TABLE_PREFIX' => array('type' => 'String', 'default' => 'typ_')
            ),
        'Allow visitors to register' =>
            array(
                'ALLOW_REGISTER' => array('type' => 'bool', 'default' => true)
            )
    );

    function __construct() {
    }

    public function install($data) {
        // Check values are present
        if (empty($data->dbConnectionString) || empty($data->dbUser) || empty($data->salt)) {
            return $this->error('MISSING_VALUES');
        }

        // Connect to database
        $connect = $this->connectTo($data->dbConnectionString, $data->dbUser, $data->dbPassword);
        if (!$connect) {
            return $this->error('CANT_CONNECT_TO_DATABASE');
        }

        // Create database schema
        $this->createDatabaseSchema($connect);

        // Write configuration to conf.php file
        $this->writeConfiguration($data);

        return $this->ok();
    }

    function connectTo($connectionString, $user, $password) {
        try {
            $pdo = @new \PDO($connectionString, $user, $password);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(\Exception $e) {
            return null;
        }
    }

    /**
     * @param $data
     */
    function writeConfiguration($data) {
        $fields = $this->fields;

        $fields['Database configuration']['DB_CONNECTIONSTRING']['value'] = $data->dbConnectionString;
        $fields['Database configuration']['DB_USER']['value'] = $data->dbUser;
        $fields['Database configuration']['DB_PASSWORD']['value'] = $data->dbPassword;
        $fields['Database configuration']['DB_TABLE_PREFIX']['value'] = $data->dbPrefix;

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

        $this->writeToFile($content);
    }

    /**
     * @param $content
     */
    function writeToFile($content) {
        file_put_contents(CONF_FILENAME, $content);
    }

    /**
     * Execute SQL installation scripts.
     *
     * @param \PDO $connect
     */
    function createDatabaseSchema($connect) {
        $dir = opendir(ROOT_DIR . '/install/');
        while ($dir && ($file = readdir($dir)) !== false) {
            if ($file !== '.' && $file !== '..') {
                $connect->exec(file_get_contents(ROOT_DIR . '/install/' . $file));
            }
        }
    }

    /**
     * @return array
     */
    function ok() {
        return array(
            'status' => 'OK',
            'msg' => __f('Installation', 'Ended', Utils::serverUrl())
        );
    }

    /**
     * @param $msg
     * @return array
     */
    function error($msg) {
        return array(
            'status' => 'ERROR',
            'code' => $msg
        );
    }
}
