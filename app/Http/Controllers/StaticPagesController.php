<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    //
    public function home(){
        // return '主页';
        return view('staticPages/home');
    }

    public function help(){
        // return '帮助页';
        return view('staticPages/help');
    }

    public function about(){
        // return '关于页';
        return view('staticPages/about');
    }
}
