<?php
namespace TouchYourPass\service;

use TouchYourPass\AbstractTestCase;

class EntryServiceUnitTest extends AbstractTestCase {

    /**
     * @test
     */
    public function shouldSearchEntriesByUserId() {
        // given
        $mockUserRepository = $this->mockEntryRepository();
        $service = new EntryService($mockUserRepository);
        $_SESSION['user'] = new \stdClass();
        $_SESSION['user']->id = 666;

        // stub
        $mockUserRepository->expects($this->once())->method('findAllByUserId')->with(666);

        // when
        $service->findByConnectedUser();

        // then

    }

    private function mockEntryRepository() {
        $entryRepository = $this->getMockBuilder('\\TouchYourPass\\repository\\EntryRepository')
            ->disableOriginalConstructor()
            ->getMock();
        return $entryRepository;
    }

}
