<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{

    use CanLoadRelationships;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Event::class , 'event') ; 
        $this->middleware('throttle:60,1')->only(['store','destroy']);
    }

    private  array $relations = ['user', 'attendees', 'attendees.user'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = $this->loadRelationships(Event::query());

        return EventResource::collection(

            $query->latest()->paginate()
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([

            ...$request->validate([
                "name" => "required|string|max:255",
                "description" => "nullable|string",
                "start_date" => "required|date",
                "end_date" => "required|date|after:start_time",
            ]),
            
            "user_id" => $request->user()->id
        ]);

        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {

        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {


        if(Gate::denies('update-event' , $event)) {
            abort(403, 'you are not authorized to update this event!'); 
        }

        $event->update(
            $request->validate([
                "name" => "sometimes|string|max:255",
                "description" => "nullable|string",
                "start_date" => "sometimes|date",
                "end_date" => "sometimes|date|after:start_time",
            ])
        );

        return new EventResource($this->loadRelationships($event));

        // return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            "message" => "this event has been deleted!"
        ]);
    }
}