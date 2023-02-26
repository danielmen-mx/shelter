<?php

namespace Tests\Unit;

use App\Models\Guest;
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
    }

    /** @test */
    function guest_request_match_with_guest_list()
    {
        $this->createGuestList();
        $request = $this->createRequest('POST', $this->getNameArray());
        $guestInLists = GuestList::get();

        $guestInLists->each(function ($guestList) use ($request) {
            $match = $guestList->match($request);

            if ($match == false) return;

            $this->assertComparison($guestList, $request);
        });

        $this->assertTrue($guestInLists->count() > 1);
    }

    /** @test */
    function guest_request_doesnt_match_with_any_guest_list()
    {        
        $request = $this->createRequest('POST', $this->getNameArray());
        $guestInLists = GuestList::get();

        $guestInLists->each(function ($guestList) use ($request) {
            $match = $guestList->match($request);

            if ($match == false) return;

            $this->assertTrue(false);
        });

        $this->assertTrue($guestInLists->count() > 1);
    }

    /** @test */
    function guest_request_only_have_one_name_and_last_name_match_with_guest_list()
    {
        $fullName = [
            'first_name' => $this->firstName,
            'second_name' => '',
            'first_last_name' => $this->firstLastName,
            'second_last_name' => '',
        ];

        $guestList = GuestList::factory()->create($fullName);
        $request = $this->createRequest('POST', $fullName);

        $this->assertTrue($guestList->match($request));
    }

    /** @test */
    function guest_list_related_with_guest()
    {
        $guest = $this->createGuest();
        $guestList = $this->createGuestList($guest->id);

        $guestRelation = $guestList->guest;
        $this->assertComparison($guest, $guestRelation);
    }

    private function assertComparison($value1, $value2)
    {        
        $this->assertTrue(
            $value1->first_name == $value2->first_name,
            $value1->second_name == $value2->second_name,
            $value1->first_last_name == $value2->first_last_name,
            $value1->second_last_name == $value2->second_last_name
        );
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

    private function createGuest()
    {
        return Guest::factory()->create($this->getNameArray());
    }

    private function createGuestList($guestListId = null)
    {        
        $array = $this->getNameArray();
        $array['guest_id'] = $guestListId;
        return GuestList::factory()->create($array);
    }
}
