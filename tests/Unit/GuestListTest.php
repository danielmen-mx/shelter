<?php

namespace Tests\Unit;

use App\Models\GuestList;
use Illuminate\Support\Facades\Log;
use Tests\TestCase as TestsTestCase;

# vendor/bin/phpunit tests/Unit/GuestListTest.php
class GuestListTest extends TestsTestCase
{
    protected $firstName;
    protected $secondName;
    protected $firstLastName;
    protected $secondLastName;

    public function setUp(): void
    {
        parent::setUp();
        GuestList::factory(10)->create();
        $this->setFullName();
        $this->createGuestList();
    }

    /** @test */
    function guest_request_match_with_guest_list()
    {   
        $request = $this->createRequest('POST', $this->getNameArray());
        $guestInLists = GuestList::get();
        // exec the search of match name
        // assert the one who match
    }

    private function getNameArray()
    {
        return [
            'first_name' => $this->firstName,
            'second_name' => $this->secondName,
            'first_last_name' => $this->firstLastName,
            'second_last_name' => $this->secondLastName,
        ];
    }

    private function setFullName()
    {                
        $this->firstName = $this->createNames();
        $this->secondName = $this->createNames();
        $this->firstLastName = $this->createLastNames();
        $this->secondLastName = $this->createLastNames();
    }

    private function createGuestList()
    {
        return GuestList::factory()->create($this->getNameArray());
    }
}
