<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Guest extends JsonResource
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
            'first_name' => $this->hasAttribute('first_name'),
            'second_name' => $this->hasAttribute('second_name'),
            'first_last_name' => $this->hasAttribute('first_last_name'),
            'second_last_name' => $this->hasAttribute('second_last_name'),
            'tickets' => $this->getTickets()
        ];
    }
}
