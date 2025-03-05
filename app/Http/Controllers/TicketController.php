<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;
use App\Http\Controllers\ResponseController;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketModRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Gate;

class TicketController extends ResponseController
{
    public function getTickets() {
        if ( Gate::allows("user")) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }
        $tickets = Ticket::with('event', 'user')->get();
        return $this->sendResponse(TicketResource::collection($tickets), "Sikeres olvasás");
    }

    public function addTicket(TicketRequest $request) {
        $user = auth()->user();
    
        if (!$user) {
            return $this->sendError("Autentikációs hiba", "Nem található felhasználó", 401);
        }
        $request->validated();
    
        $ticket = new Ticket([
            "event_id" => $request['event_id'],
            "user_id" => $user->id,
            "type" => $request['type'],
            "price" => $request['price']
        ]);
    
        $ticket->save();
        return $this->sendResponse(new TicketResource($ticket), "Sikeres hozzáadás");
    }
    

    public function modifyTicket(TicketRequest $request) {
        if ( Gate::allows("user")) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }
        
        $ticket = Ticket::find($request['id']);
        if( is_null( $ticket )) {
            return $this->sendError( "Adathiba", [ "Nem létező jegy" ] );

        }
        $ticket->type = $request['type'];
        $ticket->price = $request['price'];
        $ticket->save();
        return $this->sendResponse(new TicketResource($ticket), "Sikeres módosítás");




    }

    public function destroyTicket(Request $request) {
        if ( !Gate::allows("organizer") ) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }
        $ticket = Ticket::find($request['id']);

        if( is_null( $ticket )) {

            return $this->sendError( "Adathiba", [ "A jegy nem létezik" ], 405 );

        }
        $ticket->delete();

        return $this->sendResponse($ticket, "Sikeres törlés");
    }
}
