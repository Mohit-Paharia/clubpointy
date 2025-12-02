<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Club $club, Event $event)
    {
        return view('club.event.show', [
            'event' => $event
        ]);
    }

    public function create(Club $club) 
    {
        return view('club.event.create', [
            'club' => $club
        ]);
    }
    
    public function store(Club $club, Request $request) 
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:255',
            'address' => 'required|max:255',
            'host_id' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'country' => 'required|max:50',
        ]);

        
        $event = Event::create([
            'name'=> $request->name,
            'description'=> $request->description,
            'address' => $request->address,
            'club_id' => $club->id,
            'host_id' => $request->host_id,
            'coordinator_id' => $request->coordinator_id,
            'location_id' => Location::firstOrCreate([
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country 
            ])->id
        ]);
        
        return redirect()->route('club.event.show', [
            'club' => $club->id,
            'event' => $event->id,
        ]);
    }
    public function update(Request $request, Club $club, Event $event) 
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:255',
            'address' => 'required|max:255',
            'host_id' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'country' => 'required|max:50',
        ]);
        
        $event->update($validated);

        return back()->with('success', 'Event updated!');
    }

    public function delete(Club $club, Event $event)
    {
        $event->delete();
        return response()->json([
            'success' => true,
            'message' => $event . 'Event is removed Club!'
        ]);
    }

}
