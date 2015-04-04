<?php
namespace TouchYourPass\service;

use TouchYourPass\AbstractTestCase;

class UserServiceUniTest extends AbstractTestCase {

    const AZE_HASHED_WITH_SALT = 'eaff07f144d5e9cc29f73c473deface0f69849057d26e8fc2b6e5095a78be6178382e26ef95af4e302daceb00b64f0ee01bdd30c25ad6dc13161d42236c5e8d9';

    /**
     * @test
     */
    public function shouldNotAuthenticateUserWithWrongName() {
        // given
        $wrongName = 'WRONG NAME';
        $userRepository = $this->mockUserRepository();
        $service = new UserService($userRepository);

        // stub
        $userRepository->expects($this->once())->method('findByName')->willReturn(false);

        // when
        $authenticated = $service->authenticate($wrongName, null);

        // then
        $this->assertFalse($authenticated);
    }

    /**
     * @test
     */
    public function shouldNotAuthenticateUserWithWrongPassphrase() {
        // given
        $userRepository = $this->mockUserRepository();
        $service = new UserService($userRepository);
        $foundUser = new \stdClass();
        $foundUser->passphrase = self::AZE_HASHED_WITH_SALT;

        // stub
        $userRepository->expects($this->once())->method('findByName')->willReturn($foundUser);

        // when
        $authenticated = $service->authenticate(null, '123');

        // then
        $this->assertFalse($authenticated);
    }

    /**
     * @test
     */
    public function shouldAuthenticateUserWithGoodCredential() {
        // given
        $userRepository = $this->mockUserRepository();
        $service = new UserService($userRepository);
        $dbUser = new \stdClass();
        $dbUser->passphrase = self::AZE_HASHED_WITH_SALT;

        // stub
        $userRepository->expects($this->once())->method('findByName')->willReturn($dbUser);

        // when
        $authenticated = $service->authenticate(null, 'aze');

        // then
        $this->assertSame($dbUser, $authenticated);
    }

    /**
     * @test
     */
    function hashShouldUseSha512WithSalt() {
        // given
        $userRepository = $this->mockUserRepository();
        $service = new UserService($userRepository);
        $passphrase = 'aze';
        $expected = self::AZE_HASHED_WITH_SALT;

        // when
        $hashed = $this->invoke($service, 'hash', $passphrase);

        // then
        $this->assertEquals($expected, $hashed);
    }

    private function mockUserRepository() {
        $userRepository = $this->getMockBuilder('\\TouchYourPass\\repository\\UserRepository')
            ->disableOriginalConstructor()
            ->getMock();
        return $userRepository;
    }

}
