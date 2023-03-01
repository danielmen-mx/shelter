<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseCollection;
use App\Models\Guest;
use App\Models\GuestList;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $responses = Response::get();

            return $this->responseWithData(new ResponseCollection($responses), 'Lista de invitados confirmados.');
        } catch (\Exception $e) {
            return $this->responseWithError($e, 'Algo anda mal.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // example: 
        $guestId = "asdjg-87a6s7-sdst87-7d6ass";
        $guestListId = "sdakh987-sd89a768-09ds8a-sa7as";
        $guest = Guest::where('uuid', $guestId)->firstOrFail();
        $guestList = GuestList::where('uuid', $guestListId)->firstOrFail();
        $tickets = $guestList->getTickets();

        $data = [
            'guest_id' => $guest->id,
            'guest_list_id' => $guestList->id,
            'tickets' => $tickets
        ];

        $response = Response::create($data);

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
