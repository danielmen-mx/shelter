<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\GuestList;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // validation
            // validation must return an array
            // complete when findmatch guest return empty array and some record behavior
            $existsInGuests = (new Guest())->findMatch('Guest', $request);

            if ($existsInGuests->count() > 1) return dd('update guest && and return message with record updated');

            $guestList = (new GuestList())->findMatch('GuestList', $request);

            // complete behavior for when guest list is find and not
            if (!$guestList) return response()->json([
                                'statusCode' => 404,
                                'message' => 'Upss, al parecer no estas en la lista de invitados, revisa que tu nombre este bien escrito.'
                            ]);

            $data = $this->extracData($request);
            $guest = Guest::create($data);
            $guestList->update(['guest_id' => $guest->id]);
            $response = Response::create([
                'guest_id' => $guest->id,
                'guest_list_id' => $guestList,
                'tickets' => $guestList->getTickets()
            ]);

        } catch (\Throwable $th) {
          //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function show(Guest $guest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function edit(Guest $guest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guest $guest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guest $guest)
    {
        //
    }

    private function extracData(Request $request): array
    {
        $keys = (new Guest())->getFillable();

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $request->$key;
        }

        return $data;
    }
}
