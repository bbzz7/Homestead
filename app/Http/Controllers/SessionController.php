<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function __construct() {
        $this->middleware('guest',[
           'only'=>['create'],
        ]);
    }

    //
    public function create() {
        // session(['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d' => 1]);
        // dd(session()->all());
        return view('sessions.create');
    }

    //
    public function store(Request $request) {
        $credentials = $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials,$request->has('remember'))) {
            // dd(Auth::user());
            // dd(session()->all());
            session()->flash('success', '欢迎回来！');
            return redirect()->intended(route('users.show', [Auth::user()]));
        } else {
            // dd(session()->all());
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    //
    public function destroy(){
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
