<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Response extends JsonResource
{
    use AdvancedResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->hasAttribute('uuid'),
            'name' => $this->guest->getFullName(),
            'assistance' => $this->guest->assistance,
            'tickets' => $this->guestList->getTickets()
        ];
    }
}
