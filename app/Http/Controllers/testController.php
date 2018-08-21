<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;

class testController extends Controller
{
    public function index() {
        $guests = Guest::all();

        $response = json_encode($guests);
        return response($response);
    }
}
