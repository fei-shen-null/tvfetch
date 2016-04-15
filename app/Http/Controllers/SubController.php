<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\SubTv;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Session;

class SubController extends Controller
{
    private $email;
    private $user;

    public function login(Request $request)
    {
        $this->checkEmail($request);
        return response(1)->cookie('email', $this->email, 60 * 24 * 365, null, null, null, false);
    }

    public function checkEmail(Request $request)
    {
        //use post/get
        if (!Session::has('email') && !Cookie::has('email')) {
            $this->validate($request, [
                'email' => 'required|email|max:255'
            ]);
            $this->email = $request->email;

        } //use session
        elseif (Session::has('email')) {
            $this->email = Session::get('email');
        }//use cookie
        elseif (Cookie::has('email')) {
            $this->email = Cookie::get('email');
        } else {
            abort(403, 'Unauthorized action.');
        }
        $this->user = User::byEmail($this->email);

    }

    public function logout(Request $request)
    {
        Session::forget('email');
        $cookie = Cookie::forget('email');
        return back()->cookie($cookie);
    }

    public function sub(Request $request, $tv)
    {
        $this->checkEmail($request);
        SubTv::firstOrCreate([
            'tv_id' => $tv,
            'user_id' => $this->user->id
        ]);
        return response(1)->cookie('email', $this->email, 60 * 24 * 365, null, null, null, false);
    }


    public function unSub(Request $request, $tv)
    {
        $this->checkEmail($request);
        return response(SubTv::where('user_id', $this->user->id)->where('tv_id', $tv)->delete());
    }
}
