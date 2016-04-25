<?php

namespace App\Http\Controllers;


use App\TvList;
use App\User;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;
use Session;
use Storage;

class IndexController extends Controller
{

    public function index()
    {
        if (!Session::has('email') && Cookie::has('email')) {
            Session::put('email', Cookie::get('email'));
        }
        $tvList = Cache::remember('index.tvList', 400, function () {
            return TvList::join('tv', 'tv_list.tv_id', '=', 'tv.id')->get()->groupBy('day_of_week');
        });
        $subList = new Collection;
        if (Session::has('email')) {
            //if not in database, revoke cookie|session
            if (!User::hasEmail(Session::get('email'))) {
                return (new SubController())->logout();
            }
            $subList = User::byEmail(Session::get('email'))->subTv()->whereIn('tv_id', TvList::all())->pluck('tv_id');
        }
        return response()->view('index', compact(['tvList', 'subList']));
    }

    public function tvDetail($id)
    {
        $file = 'tv/' . $id . '.html';
        if (!Storage::exists($file)) {
            return response('Sorry Not Found', 404);
        }
        $tmp=Storage::get($file);
        Cache::add('tvDetail.'.$id,$tmp,400);
        return response($tmp);
    }
}
