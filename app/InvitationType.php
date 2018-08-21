<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitationType extends Model
{
    public function getByUid($uuid) {
        $invitationTypes = InvitationType::where('hash', $uuid)->first();
        return $invitationTypes;
    }

    public function getByUids($uuids) {
        $massInvitationTypes = InvitationType::whereIn('hash', $uuids)->get();
        return $massInvitationTypes;
    }

    protected $table = 'invitationTypesPerGuest';
}
