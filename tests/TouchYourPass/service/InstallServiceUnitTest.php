<?php
namespace TouchYourPass\service;

use TouchYourPass\AbstractTestCase;

class InstallServiceUnitTest extends AbstractTestCase {

    /**
     * @testt
     */
    public function should_return_error_when_cant_connect_to_database() {
        // given
        $service = $this->getMockBuilder('\\TouchYourPass\\service\\InstallService')
            ->setMethods(array('connectTo'))
            ->getMock();
        $data = $this->buildData('connectionstring', 'user', 'pwd', 'prefix', 'salt', 'on');

        // stub
        $service->expects($this->once())->method('connectTo')->willReturn(null);

        // when
        $result = $service->install($data);

        // then
        $this->assertEquals(array('status' => 'ERROR', 'code' => 'CANT_CONNECT_TO_DATABASE'), $result, 'Installation should return error if it can\'t connect to database.');
    }

    /**
     * @testt
     */
    public function should_return_error_when_missing_required_values() {
        // given
        $service = $this->getMockBuilder('\\TouchYourPass\\service\\InstallService')
            ->setMethods(null)
            ->getMock();

        // stub

        // when
        $missingConnectionString = $service->install($this->buildData('', 'user', 'pwd', 'prefix', 'salt', 'on'));
        $missingDbUser = $service->install($this->buildData('connectionstring', '', 'pwd', 'prefix', 'salt', 'on'));
        $missingSalt = $service->install($this->buildData('connectionstring', 'user', 'pwd', 'prefix', '', 'on'));

        // then
        $this->assertEquals(array('status' => 'ERROR', 'code' => 'MISING_VALUES'), $missingConnectionString);
        $this->assertEquals(array('status' => 'ERROR', 'code' => 'MISING_VALUES'), $missingDbUser);
        $this->assertEquals(array('status' => 'ERROR', 'code' => 'MISING_VALUES'), $missingSalt);
    }

    /**
     * @testt
     */
    public function should_write_to_file_when_everything_is_checked() {
        // given
        $service = $this->getMockBuilder('\\TouchYourPass\\service\\InstallService')
            ->setMethods(array('connectTo', 'createDatabaseSchema', 'writeConfiguration', 'ok'))
            ->getMock();

        // stub
        $service->expects($this->once())->method('connectTo')->willReturn(true);
        $service->expects($this->once())->method('createDatabaseSchema');
        $service->expects($this->once())->method('writeConfiguration');
        $service->expects($this->once())->method('ok');

        // when
        $service->install($this->buildData('connectionstring', 'user', 'pwd', 'prefix', 'salt', 'on'));

        // then
    }

    /**
     * @param string $dbConnectionString
     * @param string $dbUser
     * @param string $dbPassword
     * @param string $dbPrefix
     * @param string $salt
     * @param string $allowRegister
     * @return \stdClass
     */
    private function buildData($dbConnectionString, $dbUser, $dbPassword, $dbPrefix, $salt, $allowRegister) {
        $data = new \stdClass();
        $data->dbConnectionString = $dbConnectionString;
        $data->dbUser = $dbUser;
        $data->dbPassword = $dbPassword;
        $data->dbPrefix = $dbPrefix;
        $data->salt = $salt;
        $data->allowRegister = $allowRegister;
        return $data;
    }

}
