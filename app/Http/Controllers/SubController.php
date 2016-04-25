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

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $this->checkEmail($request);
        return response(1)->cookie('email', $this->email, 60 * 24 * 365, null, null, null, false);
    }

    /**
     * @param Request $request
     */
    public function checkEmail(Request $request)
    {
        //use session
        if (Session::has('email')) {
            $this->email = Session::get('email');
        }//use cookie
        elseif (Cookie::has('email')) {
            $this->email = Cookie::get('email');
            Session::put('email', $this->email);
        }
        //use post/get
        elseif (!Session::has('email') && !Cookie::has('email')) {
            $this->validate($request, [
                'email' => 'required|email|max:255'
            ]);
            $this->email = $request->email;
        } else {
            abort(403, 'Unauthorized action.');
        }
        $this->user = User::byEmail($this->email);
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        Session::forget('email');
        $cookie = Cookie::forget('email');
        return back()->cookie($cookie);
    }

    /**
     * @param Request $request
     * @param $tv
     * @return mixed
     */
    public function sub(Request $request, $tv)
    {
        $this->checkEmail($request);
        SubTv::firstOrCreate([
            'tv_id' => $tv,
            'user_id' => $this->user->id
        ]);
        return response(1)->cookie('email', $this->email, 60 * 24 * 365, null, null, null, false);
    }


    /**
     * @param Request $request
     * @param $tv
     * @return mixed
     * @throws \Exception
     */
    public function unSub(Request $request, $tv)
    {
        $this->checkEmail($request);
        return response(SubTv::where('user_id', $this->user->id)->where('tv_id', $tv)->delete());
    }
}
