<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use App\Models\Event;
use App\Models\Chat;

class ClubController extends Controller
{
    public function dashboard(Club $club) 
    {
        return view('club.dashboard', [
            'club' => $club
        ]);
    }

    public function acceptJoinRequest(Club $club, User $user) 
    {
        $club->members()->attach($user->id);
        $club->joinRequests()->detach($user->id);
        return response()->json([
            'success' => true,
            'message' => $user->first_name . ' ' . $user->last_name . ' joined the Club!'
        ]);
    }

    public function rejectJoinRequest(Club $club, User $user)
    {
        $club->joinRequests()->detach($user->id);
        return response()->json([
            'success' => true,
            'message' => 'Join request rejected!'
        ]);
    }

    public function blockUser(Club $club, User  $user)
    {
        $club->blockedUsers()->attach($user->id);
        $club->joinRequests()->detach($user->id);   
        $club->members()->detach($user->id);
        return response()->json([
            'success' => true,
            'message' => $user->first_name . ' ' . $user->last_name . ' is blocked from Club!'
        ]);
    }

    public function unblockedUser(Club $club, User $user)
    {
        $club->blockedUsers()->detach($user->id);
        return response()->json([
            'success' => true,
            'message' => $user->first_name . ' ' . $user->last_name . ' is unblocked from Club!'
        ]);
    }

    public function removeMember(Club $club, User $user) 
    {
        $club->members()->detach($user->id);
        return response()->json([
            'success' => true,
            'message' => $user->first_name . ' ' . $user->last_name . ' is removed from Club!'
        ]);
    }
}
