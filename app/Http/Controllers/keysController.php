<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Key;
use App\InvitationType;
use Webpatser\Uuid\Uuid;

class keysController extends Controller
{
    public function add(Request $request) {
        $key = new Key;
        $key->guestName = $request->guestName;
        $key->email = $request->email;
        $key->hash = Uuid::generate();
        $key->save();

        $invitationType = new InvitationType;
        $invitationType->hash = $key->hash;
        $invitationType->reception = $request->reception;
        $invitationType->dinner = $request->dinner;
        $invitationType->dessert = $request->dessert;
        $invitationType->save();

        //->save() returns empty here for some reason, even though it works for other models in the same way
        $newKey = Key::where('hash', $key->hash)->first();
        return response(json_encode($newKey));
    }

    public function getUnused() {
        $unusedKeys = Key::where('used', false)->get();

        return response(json_encode($unusedKeys));
    }
}
