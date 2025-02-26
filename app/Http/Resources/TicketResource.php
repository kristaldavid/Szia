<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "ticket_id"=>$this->id,
            "customer"=>[
                "email"=>$this->user->email,
                "name"=>$this->user->name
            ],  
            "event"=>[
                "id"=>$this->event->id,
                "name"=>$this->event->name,
                "description"=>$this->event->description,
                "start_date"=>$this->event->start_date,
                "end_date"=>$this->event->end_date
            ],
            "type"=>$this->type,
            "price"=>$this->price
        ];
    }
}
