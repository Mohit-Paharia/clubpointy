<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Club;

class SearchController extends Controller
{
    public function clubs(Request $request)
    {
        $query = $request->get("query");

        $clubs = Club::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

        return response()->json($clubs);
    }

    public function users(Request $request)
    {
        $query = $request->get("query");

        $users = User::where('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%")
                    ->orWhere('id', 'LIKE', "%{$query}%" )
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->get();

        return response()->json($users);
    }

    public function events(Request $request)
    {
        $query = $request->get("query");

        $events = Event::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();
                    
        return response()->json($events);
    }
}
