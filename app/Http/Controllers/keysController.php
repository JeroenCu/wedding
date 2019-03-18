<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Key;
use App\InvitationType;
use Webpatser\Uuid\Uuid;
// use Mailgun\Mailgun;

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

        // $mg = Mailgun::create('167461dcec0c81c957abfef8496bb48b-a4502f89-18ebc80b');

        // $mg->messages()->send('sandbox9b0fed6256d247e3bc78743d4e160965.mailgun.org', [
        //     'from'    => 'jeroeneneva@live.be',
        //     'to'      => $request->email,
        //     'subject' => 'Ze zei ja!',
        //     'text'    => 'Beste, '.$request->guestName.'Zoals u misschien al wist, gaan wij trouwen. Wij hopen dat u erbij kan zijn! Login-sleutel: '.$key->hash
        //   ]);

        //->save() returns empty here for some reason, even though it works for other models in the same way
        $newKey = Key::where('hash', $key->hash)->first();
        return response(json_encode($newKey));
    }

    public function getUnused() {
        $unusedKeys = Key::where('used', false)->get();

        return response(json_encode($unusedKeys));
    }
}
