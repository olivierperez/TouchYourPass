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
        $user = new \stdClass();
        $user->id = 666;

        // stub
        $mockUserRepository->expects($this->once())->method('findAllByUserId')->with($user->id);

        // when
        $service->findAllByUser($user);

        // then

    }

    private function mockEntryRepository() {
        $entryRepository = $this->getMockBuilder('\\TouchYourPass\\repository\\EntryRepository')
            ->disableOriginalConstructor()
            ->getMock();
        return $entryRepository;
    }

}
