<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    public function invitationType()
    {
        return $this->hasOne('App\InvitationType', 'hash', 'hash');
    }

    public function key()
    {
        return $this->hasOne('App\Key', 'hash', 'hash');
    }
}
