<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Song;
use App\Guest;

class guestController extends Controller
{
    public function rsvp(Request $request) {
        $guest = Guest::where('name', $request->name)->orWhere('plus1name', $request->name)->first();
        if (!$guest) {
            return response()->json([ 'errorCode' => 404, 'error' => 'unregistered guest' ], 404);
        }

        $guest->rsvp             = !!$request->rsvp;
        $guest->veggie           = $request->veggie;
        $guest->responded        = true;
        $guest->plus1attending   = !!$request->plus1attending;
        $guest->plus1veggie      = !!$request->plus1veggie;
        $guest->save();

        Song::where('guestId', $guest->id)->delete();

        $songs = json_decode($request->songs);
        foreach($songs as $song) {
            $newSong            = new Song;
            $newSong->guestId   = $guest->id;
            $newSong->title     = $song->title;
            $newSong->artist    = $song->artist;
            $newSong->save();
        }

        return response(json_encode($guest));
    }

    public function addGuest(Request $request) {
        $guest                  = new Guest;
        $guest->name            = $request->input('name');
        $guest->plus1           = $request->input('plus1');
        $guest->plus1name       = $request->input('plus1name');
        $guest->receptie        = $request->input('receptie');
        $guest->diner           = $request->input('diner');
        $guest->feest           = $request->input('feest');
        $guest->RSVP            = false;
        $guest->responded       = false;
        $guest->veggie          = false;
        $guest->plus1attending  = false;
        $guest->plus1veggie     = false;
        $guest->save();

        return response(json_encode($guest));
    }
    
    public function checkGuest(Request $request) {
        $name = $request->input('name');
        if (!isset($name)) {
            return response()->json([ 'errorCode' => 404, 'error' => 'name cannot be null' ], 404);
        }
        $guest = Guest::where('name', $name)->orWhere('plus1name', $name)->first();
        return response(json_encode($guest));
    }
}
