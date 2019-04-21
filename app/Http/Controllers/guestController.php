<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Song;
use App\Guest;

class guestController extends Controller
{
    public function rsvpGuest(Request $request) {
        $name = $request->input('name');
        if (!isset($name)) {
            return response()->json([ 'errorCode' => 404, 'error' => 'name cannot be null' ], 404);
        }
        $guest = Guest::where('name', $name)->orWhere('plus1name', $name)->first();
        if (!$guest) {
            return response()->json([ 'errorCode' => 404, 'error' => 'unregistered guest' ], 404);
        }

        $guest->rsvp             = $request->input('rsvp');
        $guest->veggie           = $request->input('veggie');
        $guest->responded        = true;
        if ($guest->plus1) {
            $guest->plus1attending   = !!$request->input('plus1attending');
            $guest->plus1veggie      = !!$request->input('plus1veggie');
        }
        $guest->save();

        if($guest->feest) {
            $deletedSongs = Song::where('guestId', $guest->id)->pluck('id')->toArray();
            Song::destroy($deletedSongs);

            $songs = $request->input('songs');

            foreach($songs as $song) {
                if (in_array('title', $song)) {
                    $newSong            = new Song;
                    $newSong->guestId   = $guest->id;
                    $newSong->title     = $song['title'];
                    if (in_array('artist', $song)) {
                        $newSong->artist    = $song['artist'];
                    }
                    $newSong->save();
                }
            }
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
        if (!$guest) {
            return response()->json([ 'errorCode' => 404, 'error' => 'unknown guest' ], 404);
        }
        return response(json_encode($guest));
    }

    public function csvGuests() {
        $guests = Guest::orderBy('responded')->get(); // All guests
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($guests, ['name', 'RSVP', 'responded', 'receptie', 'diner', 'feest', 'veggie', 'plus1', 'plus1name', 'plus1attending', 'plus1veggie', 'updated_at'])->download();
    }
}
