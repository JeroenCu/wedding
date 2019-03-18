<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Key;
use App\Guest;

class guestController extends Controller
{
    public function createOrUpdate(Request $request) {
        if (!$request->key) {
            return response()->json([ 'errorCode' => 404, 'error' => 'Guest key required' ], 404);
        }
        $guestData = Key::where('hash', $request->key)->first();
        if (!$guestData) {
            return response()->json([ 'errorCode' => 404, 'error' => 'Invalid guest key' ], 404);
        }
        $guest = Guest::where('name', $guestData->guestName)->first();
        if (!$guest) {
            $guest = new Guest;
        }
        $guest = new Guest;
        $guest->name = $guestData->guestName;
        $guest->attending = $request->attending;
        $guest->vegetarian = $request->vegetarian;
        $guest->songRequests = $request->songRequests;
        $guest->hash = $request->key;
        $guestData->used = true;

        $guest->save();
        $guestData->save();

        return response(json_encode($guest));
    }

    public function getAllGuests() {
        $guests = Guest::join('invitationTypesPerGuest', 'guests.hash', '=', 'invitationTypesPerGuest.hash')->get();
        return response(json_encode($guests));
    }
}
