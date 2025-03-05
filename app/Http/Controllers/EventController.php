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
use Illuminate\Support\Facades\Gate;


class EventController extends ResponseController
{
    public function getEvents() {
        $events = Event::with('user')->get();
        return $this->sendResponse(EventResource::collection($events), "Sikeres olvasás");
    }

    public function addEvent(EventRequest $request) {

        if ( !Gate::allows("organizer") ) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }
        $user = auth()->user();

        if (!$user) {
            return $this ->sendError("Autentikációs hiba", "Nem található felhasználó", 401);
        }
        $event = new Event();
        $event->name = $request['name'];
        $event->description = $request['description'];
        $event->location = $request['location'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->user_id = $user->id;
        $event->save();
        return $this->sendResponse(new EventResource($event), "Sikeres hozzáadás");
    }

    public function destroyEvent(Request $request) {
        if (!Gate::allows("organizer") ) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }
    
        $event = Event::find($request['id']);
    
        if (!$event) {
            return $this->sendError("Hiba", "Esemény nem található", 404);
        }
    
        $event->delete();
    
        $tickets = Ticket::where('event_id', $event->id)->get();
        
        foreach ($tickets as $ticket) {
            $ticket->delete();
        }
    
        return $this->sendResponse($tickets, "Sikeres törlés");
    }
    

    public function modifyEvent(EventModRequest $request) {
        if ( !Gate::allows("organizer") ) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }
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
