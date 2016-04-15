<?php

namespace App\Http\Controllers;


use App\SubList;
use App\TvList;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;
use Session;

class indexController extends Controller
{

    public function index()
    {
        if (!Session::has('email') && Cookie::has('email')) {
            Session::put('email', Cookie::get('email'));
        }
        $tvList = TvList::join('tv', 'tv_list.tv_id', '=', 'tv.id')->get()->groupBy('day_of_week');
        $subList = new Collection;
        if (Session::has('email')) {
            $a = Session::get('email');
            $subList = SubList::where('user_id', User::where('email', Session::get('email'))->pluck('id')->first())->whereIn('tv_id', TvList::all()->pluck('tv_id'))->pluck('tv_id');
        }
        return response()->view('index', compact(['tvList', 'subList']))->cookie('email', 'joshua.never@gmail.com', 999);
    }
}
