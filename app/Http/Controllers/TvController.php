<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Tv;

class TvController extends Controller
{
    function showTv(Tv $tv)
    {
        return view('tv', compact('tv'));
    }
}
