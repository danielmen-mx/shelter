<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest as RequestsGuest;
use App\Http\Resources\Guest as ResourcesGuest;
use App\Models\Guest;
use App\Models\GuestList;
use App\Models\Response;
use Exception;

class GuestController extends ApiController
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsGuest $request)
    {
        try {
            $data = $request->validated();
            $existsGuest = (new Guest())->findMatch('Guest', $data);

            if ($existsGuest->count() > 0) {
                $existsGuest->update(['assistance' => $data['assistance']]);
                return $this->responseWithData(new ResourcesGuest($existsGuest), 'Invitado actualizado.');
            }

            $guestList = (new GuestList())->findMatch('GuestList', $data);

            if ($guestList->count() == 0) {
                throw new Exception('Parace que no estas en la lista de invitados', 404);
            }

            $guest = Guest::create($data);
            $guestList->update(['guest_id' => $guest->id]);
            Response::create([
                'guest_id' => $guest->id,
                'guest_list_id' => $guestList->id,
                'tickets' => $guestList->getTickets()
            ]);

            return $this->responseWithData(new ResourcesGuest($guest), 'Invitado agregado.');
        } catch (\Exception $e) {
            return $this->responseWithError($e, 'Algo anda mal.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function show($guestId)
    {
        try {
            $guest = Guest::where('uuid', $guestId)->firstOrFail();
            return $this->responseWithData(new ResourcesGuest($guest), 'Invitado encontrado');
        } catch (\Exception $e) {
            return $this->responseWithError($e, 'Algo anda mal.');
        }
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
}
