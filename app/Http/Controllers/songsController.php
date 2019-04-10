<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Song;

class songsController extends Controller
{
    public function csvSongs() {
        $songs = Song::orderBy('guestId')->get(); // All songs
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($songs, ['title', 'artist', 'guestId'])->download();
    }
}
