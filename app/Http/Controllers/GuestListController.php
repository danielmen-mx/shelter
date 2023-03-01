<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuestList as ResourcesGuestList;
use App\Http\Requests\GuestList as GuestListRequest;
use App\Http\Resources\GuestListCollection;
use Illuminate\Http\Request;
use App\Models\GuestList;
use App\Models\Response;
use Exception;

class GuestListController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $guestLists = GuestList::get();

            return $this->responseWithData(new GuestListCollection($guestLists), 'Lista de invitados.');
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
    public function store(GuestListRequest $request)
    {
        try {
            $data = $request->validated();
            $guestList = (new GuestList())->findMatch('GuestList', $data);

            if ($guestList->count() > 0) {
                throw new Exception('Alguien mas de la lista coincide con ese nombre.', 409);
            }

            $guestList = GuestList::create($data);

            return $this->responseWithData(new ResourcesGuestList($guestList), 'Invitado creado.');
        } catch (\Exception $e) {
            return $this->responseWithError($e, 'Algo anda mal.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GuestList  $guestList
     * @return \Illuminate\Http\Response
     */
    public function show($guestListId)
    {
        try {
            $guestList = GuestList::where('uuid', $guestListId)->firstOrFail();

            return $this->responseWithData(new ResourcesGuestList($guestList), 'Invitado encontrado.');
        } catch (\Exception $e) {
            return $this->responseWithError($e, 'Algo anda mal.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GuestList  $guestList
     * @return \Illuminate\Http\Response
     */
    public function update(GuestListRequest $request, $guestListId)
    {
        try {
            $data = $request->validated();
            $guestList = GuestList::where('uuid', $guestListId)->firstOrFail();

            $guestList->update($data);
            return $this->responseWithData(new ResourcesGuestList($guestList), 'Invitado actualizado.');
        } catch (\Exception $e) {
            return $this->responseWithError($e, 'Algo anda mal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GuestList  $guestList
     * @return \Illuminate\Http\Response
     */
    public function destroy($guestListId)
    {
        try {
            $guestList = GuestList::where('uuid', $guestListId)->firstOrFail();
            $guest = $guestList->guest;
            $response = Response::where('guest_list_id', $guestList->id)->first();

            if ($response) {
              $response->delete();
            }

            $guestList->delete();

            if ($guest) {
              $guest->delete();
            }

            return $this->responseWithMessage('Invitado eliminado.');
        } catch (\Exception $e) {
            return $this->responseWithError($e, 'Algo anda mal.');
        }
    }
}
