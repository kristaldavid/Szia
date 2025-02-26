<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;
use App\Http\Controllers\ResponseController;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventModRequest;
use App\Http\Resources\EventResource;


class EventController extends ResponseController
{
    public function getEvents() {
        $events = Event::with('user')->get();
        return $this->sendResponse(EventResource::collection($events), "Sikeres olvasás");
    }

    public function addEvent(EventRequest $request) {
        $event = new Event();
        $event->name = $request['name'];
        $event->description = $request['description'];
        $event->location = $request['location'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->user_id = $request['user_id'];
        $event->save();
        return $this->sendResponse(new EventResource($event), "Sikeres hozzáadás");
    }

    public function destroyEvent(Request $request) {
        $event = Event::find($request['id']);
        $event->delete();

        return $this->sendResponse($event, "Sikeres törlés");
    }

    public function modifyEvent(EventModRequest $request) {
        $event = Event::find($request['id']);
        $event->name = $request['name'];
        $event->description = $request['description'];
        $event->location = $request['location'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->save();
        return $this->sendResponse(new EventResource($event), "Sikeres módosítás");
    }

    
}
